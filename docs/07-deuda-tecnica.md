# Deuda técnica y hallazgos

Inconsistencias, código vestigial y riesgos encontrados durante la exploración del código. No son bloqueantes para entender el proyecto, pero conviene tenerlos presentes antes de modificar esas áreas.

## Seguridad (flujo de pago)

Ver el detalle completo en [05-flujo-de-pago.md](05-flujo-de-pago.md):

1. La orden se marca como pagada (`payment = true`) solo porque el JavaScript del navegador lo indica — sin verificación server-side independiente del resultado real de UPagos.
2. Las rutas `POST /api/validateform`, `GET /api/efstoken`, `POST /api/verify`, `POST /api/sale` no requieren autenticación.
3. `UPagosDirectService::postData()` registra en el log de la aplicación el payload completo enviado a UPagos, incluyendo número de tarjeta y CVV.
4. El cliente Guzzle hacia UPagos usa `'verify' => false` (sin validación de certificado TLS).

Ya conocido y documentado en el propio [README.md](../README.md#pendientes-conocidos-fuera-del-alcance-de-esta-limpieza): dependencias con CVEs (Guzzle, Symfony, Livewire 2.x, Laravel 10 sin soporte de seguridad) — la vulnerabilidad crítica de dompdf ya fue corregida actualizando a `barryvdh/laravel-dompdf ^3.0`.

## Modelos y relaciones rotas o vestigiales

- `DeliveryMethod::order()` apunta a `App\Models\Order`, que **no existe** (el modelo real de pedidos es `UserOrder`). Relación muerta.
- `Category::userContact()` está declarada como `hasMany` pero `user_contacts` no tiene columna `category_id` — relación sin base real en el esquema.
- `Province::user()` está declarada como `hasMany` pero `users` no tiene columna `province_id` — relación sin base real.
- `Branch.sub_branch` (columna añadida en una migración posterior) sugiere jerarquía de sub-sucursales, pero no hay FK real ni self-relation en el modelo `Branch` — la jerarquía, si se usa, se maneja a mano en la capa de aplicación, no vía Eloquent.
- `UserPurchasedProduct` declara `order_id` en su `$fillable`, pero la columna real de la tabla es `user_order_id`. Conviene verificar en el código que crea estas filas (`ConfirmComponent::purchasedProduct()`) que no dependa silenciosamente de mass-assignment con la clave equivocada.
- `Product::$fillable` incluye `starts`, que no es una columna real de `products` (el rating vive en la tabla aparte `product_starts`) — campo vestigial.

## Inconsistencias de conteo en el carrito

`CartTrait::totalProducts()` cuenta **líneas** de carrito, mientras que en otros puntos del código (`CartComponent`) se usa `sum('units')` para el total de unidades. Si ambos se muestran en la misma pantalla pueden dar números distintos para lo que el usuario espera sea "cantidad de productos en el carrito" — conviene unificar el criterio antes de tocar esa UI.

## Modelos Eloquent duplicando el paquete Spatie Permission

El proyecto usa el paquete estándar `spatie/laravel-permission` (trait `HasRoles`, migraciones estándar) pero además define modelos Eloquent propios `App\Models\Role` y `App\Models\ModelHasRole` que mapean sobre las mismas tablas `roles`/`model_has_roles`, para poder hacer joins/eager-loading normales sobre roles de usuario en paralelo a la API del paquete. No es un bug, pero es una duplicación de responsabilidad a tener en cuenta si se toca el sistema de roles: hay dos formas distintas de consultar lo mismo.

## Otras observaciones menores

- `App\Mail\Wholesaler` importa `DragonCode\Contracts\Queue\ShouldQueue` en vez del contrato estándar `Illuminate\Contracts\Queue\ShouldQueue` — vale la pena confirmar que el correo realmente se encola como se espera.
- `NavigationMenuSm` duplica parcialmente la lógica de carga de carrito de `CartComponent` en vez de reutilizarla, y su `clearCart()` reemite hacia `CartComponent` en vez de resolver localmente — funciona, pero es una duplicación evitable.
- Todos los componentes de `AdminPanel/Reports/*Sales` repiten la misma forma (query agregada + cálculo de crecimiento + gráficos `LaravelChart`) — candidato natural a extraer a un trait/servicio común si el área de reportes sigue creciendo.
- **Cobertura de tests**: toda la suite de tests existente (`tests/Feature/`) cubre el scaffolding de Jetstream/Fortify (auth, 2FA, perfil, tokens API). No existe ningún test de Feature para carrito, checkout/pago, gestión de pedidos, generación de PDF, correos transaccionales o el panel admin — es decir, la lógica de negocio propia del marketplace no tiene cobertura automatizada.
- El favicon se generó a partir del logo original del cliente (ver README) — pendiente de regenerar desde el nuevo logo SVG en `resources/views/components/`.
