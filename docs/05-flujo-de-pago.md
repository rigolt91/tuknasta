# Flujo de pago (checkout con UPagos)

MarketPlaza integra la pasarela externa **UPagos** (`https://www.upagosdirect.com/api/`) para cobros con tarjeta de crédito/débito, con soporte opcional de 3D Secure 2 (SDK `Elavon3DSWebSDK`).

## Componentes involucrados

- `App\Http\Livewire\Payment\{PaymentComponent, DeliveryComponent, ConfirmComponent}` — wizard de checkout (ver [04-livewire.md](04-livewire.md)).
- `App\Http\Controllers\PaymentController` — expone `routes/api.php`.
- `App\Http\Controllers\UPagosDirectService` — cliente Guzzle hacia la API de UPagos.
- `App\Models\UpagosDirect` — configuración singleton (token, modo demo/producción).
- JavaScript embebido en `resources/views/livewire/payment/confirm-component.blade.php`.

## Paso a paso

1. El usuario navega `/payment` → `/payment/delivery` → `/payment/confirm/{method}`, seleccionando dirección de envío y método de entrega (ver [04-livewire.md](04-livewire.md) para el detalle del wizard).
2. `ConfirmComponent::mountConfirm()` calcula el `amount` total del carrito y, si el método de entrega es "a domicilio", suma la tarifa de `RateTransportation` según el municipio del contacto.
3. En el formulario de confirmación, el JavaScript del navegador:
   1. Llama `POST /api/validateform` → `PaymentController@validateForm` valida (server-side) los campos de tarjeta: nombre, dirección, código postal, número de orden, número de tarjeta (8-16 dígitos), `exp_date` (`m/y`), CVV, monto.
   2. Según el país detectado (`geoInfo.countryCode`; se hace bypass del 3DS2 para `CU`/`UNKNOWN`):
      - **Sin 3DS2**: arma el payload (monto + transporte, `merchant_txn_id` = número de orden, datos de tarjeta, dirección AVS) y llama directo `POST /api/sale`.
      - **Con 3DS2**: `GET /api/efstoken` → `UPagosDirectService::getEfsToken()` → `POST efstoken` a UPagos → token 3DS2; se ejecuta el challenge 3D Secure en el navegador con el SDK de Elavon; al completarse, se arma el payload con los datos de tarjeta + campos 3DS y se llama `POST /api/sale`.
   3. `PaymentController@sale` reenvía el payload completo a `UPagosDirectService::postData('creditcard/sale', ...)`, que hace `POST creditcard/sale` contra la API real de UPagos con el `Bearer token` configurado.
   4. La respuesta se evalúa **en el navegador**: si `paymentResult.result === '0'`, se considera pago exitoso.
4. **Solo entonces** el JS llama al método Livewire `@this.paymentConfirm()`, que:
   - Crea el `UserOrder` (`order_status_id = 1`, **`payment = true`**, referencia al `user_contact_id` elegido).
   - Crea una línea `user_purchased_product` por cada ítem del carrito (snapshot de producto/precio/unidades/monto) y borra las líneas de `carts`.
   - Emite los eventos Livewire `deleteUserJob` y `refreshCart`.
   - Envía el correo `OrderShipped` (to = cliente, cc = contacto de envío, bcc = `mail.from.address`).
   - Redirige a `/cart/cart-details`.

## Riesgos de seguridad detectados

Estos hallazgos son del código actual, no juicios de valor — se documentan para que se tengan en cuenta antes de exponer este flujo en un entorno con pagos reales:

1. **Confirmación de pago sin verificación server-side.** La orden se marca `payment = true` únicamente porque el JavaScript del navegador llamó a `paymentConfirm()` tras interpretar `result === '0'` de la respuesta de UPagos. No hay una segunda verificación desde el servidor (webhook de UPagos, o una consulta server-side al estado real de la transacción) antes de dar el pedido por pagado. Un cliente podría, en teoría, manipular la respuesta en el navegador y disparar `paymentConfirm()` sin haber pagado.
2. **Rutas de pago sin autenticación.** `POST /api/validateform`, `GET /api/efstoken`, `POST /api/verify` y `POST /api/sale` (`routes/api.php`) no llevan `auth:sanctum` ni ningún otro middleware de autenticación — solo el `throttle:api` (60/min) global. Cualquiera con la URL puede invocarlas directamente, sin pasar por el wizard de checkout ni estar logueado.
3. **Datos de tarjeta en los logs.** `UPagosDirectService::postData()` ejecuta `Log::debug($endpoint, $data)` antes de cada llamada — como `postData` es el método usado por `/verify` y `/sale`, esto escribe en el log de la aplicación (`storage/logs/`) el payload completo enviado a UPagos, incluyendo número de tarjeta y CVV. Esto es un problema de cumplimiento PCI-DSS si se usa en producción con tarjetas reales.
4. **Verificación SSL deshabilitada.** El cliente Guzzle hacia UPagos se construye con `'verify' => false`, es decir, no valida el certificado TLS del servidor remoto — expone la conexión a un ataque man-in-the-middle.

Estos cuatro puntos deberían revisarse (verificación server-side del resultado, autenticar las rutas de pago, quitar el log de payload con datos de tarjeta, y habilitar `verify => true`) antes de usar este flujo con una pasarela y tarjetas reales.
