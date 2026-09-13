# Deuda técnica y hallazgos

Inconsistencias, código vestigial y riesgos encontrados durante la exploración del código. Los puntos marcados como **corregido** ya se resolvieron; se documentan igual para que quede constancia de qué cambió y por qué.

## Seguridad (flujo de pago) — corregido

Ver el detalle completo en [05-flujo-de-pago.md](05-flujo-de-pago.md).

1. **Confirmación de pago sin verificación server-side.** `ConfirmComponent::paymentConfirm()` ahora llama server-side a `creditcard/verify` (UPagos) con el `merchant_txn_id` de la orden antes de crear el `UserOrder` y marcarlo como pagado; si UPagos no confirma la transacción, la orden no se crea.
2. **Rutas de pago sin autenticación.** `POST /api/validateform`, `GET /api/efstoken`, `POST /api/verify` y `POST /api/sale` ahora requieren sesión autenticada (`auth:sanctum`, con `EnsureFrontendRequestsAreStateful` habilitado en el grupo `api`). El JS de `confirm-component.blade.php` envía el token CSRF en cada `fetch`.
3. **Datos de tarjeta en los logs.** Se eliminó el `Log::debug($endpoint, $data)` de `UPagosDirectService::postData()`.
4. **Verificación SSL deshabilitada.** El cliente Guzzle hacia UPagos ahora usa `'verify' => true`.

Cubierto por tests: `tests/Feature/Payment/ConfirmComponentTest.php` (orden creada solo cuando UPagos verifica el pago; rechazada si no).

Dependencias con CVEs — ver detalle actualizado en el propio [README.md](../README.md#pendientes-conocidos-fuera-del-alcance-de-esta-limpieza): se actualizó todo lo posible dentro de las majors actuales (`composer update` + `npm audit fix`); solo quedan 3 advisories en `laravel/framework` sin fix dentro de la línea 10.x (requieren Laravel 12.60+/13.10+), documentados e ignorados explícitamente en `composer.json`. Migrar a Laravel 12/13 y Livewire 3.x sigue fuera de alcance. Actualizar esas dependencias sigue fuera de alcance.

## Modelos y relaciones rotas o vestigiales — corregido

- `DeliveryMethod::order()` apuntaba a `App\Models\Order`, inexistente. Se reemplazó por `DeliveryMethod::userOrder()` hacia `UserOrder`, que sí tiene la FK real (`user_orders.delivery_method_id`).
- `Category::userContact()` y `Province::user()` (declaradas `hasMany` sin columna FK real ni uso en el código) se eliminaron.
- `Branch` ahora expone `parentBranch()`/`subBranches()` como self-relation real sobre la columna `sub_branch`.
- `UserPurchasedProduct::$fillable` corregido de `order_id` a `user_order_id` (columna real de la tabla).
- `Product::$fillable` ya no incluye `starts` (campo vestigial, sin uso).

## Inconsistencias de conteo en el carrito — corregido

`CartTrait::totalProducts()` y `CartComponent` calculaban el total del carrito de dos formas distintas (líneas vs. `sum('units')`). Se unificó: ambos usan `sum('units')`, y ese cálculo vive en un único lugar (`App\Http\Traits\CartSummaryTrait`, ver abajo). Cubierto por `tests/Feature/CartTest.php`.

## Modelos Eloquent duplicando el paquete Spatie Permission — corregido

El proyecto definía modelos Eloquent propios `App\Models\Role` y `App\Models\ModelHasRole` en paralelo a `spatie/laravel-permission`, para poder hacer joins/eager-loading normales sobre roles de usuario. Se eliminaron ambos modelos y `User::modelHasRole()`; el panel admin (`AdminPanel/User/{Create,Edit}Component`, `user-component.blade.php`) ahora usa directamente `Spatie\Permission\Models\Role` y la relación `roles()` que trae el trait `HasRoles` (con eager loading vía `User::with('roles')` en el listado). Cubierto por `tests/Feature/AdminPanel/UserRoleManagementTest.php`.

## Otras observaciones menores

- `App\Mail\Wholesaler` importaba `DragonCode\Contracts\Queue\ShouldQueue` en vez del contrato estándar `Illuminate\Contracts\Queue\ShouldQueue` — **corregido**.
- `NavigationMenuSm` duplicaba la lógica de carga de carrito de `CartComponent` — **corregido**: ambos ahora usan `App\Http\Traits\CartSummaryTrait`, que centraliza `mountCart()`.
- Los componentes `AdminPanel/Reports/{Weekly,Monthly,Year}Sales` repetían el mismo cálculo de crecimiento (`overallGrowth()`) — **corregido**: se extrajo a `App\Http\Traits\SalesGrowthTrait`. La construcción de las opciones de `LaravelChart` (que sí difiere de forma no trivial entre los tres) se dejó tal cual: forzar esa parte a una abstracción común habría sido una abstracción prematura sobre parámetros que legítimamente varían.
- **Cobertura de tests** — mejorada, no exhaustiva. Se agregaron tests de Feature para carrito (`CartTest`), verificación server-side del pago (`Payment/ConfirmComponentTest`) y gestión de roles de usuario en el panel admin (`AdminPanel/UserRoleManagementTest`), además de factories para los modelos de catálogo/checkout (`Category`, `Subcategory`, `Branch`, `Product`, `Province`, `Municipality`, `UserContact`, `DeliveryMethod`, `OrderStatus`) que no existían. Sigue sin haber tests de generación de PDF ni del resto del panel admin (reportes, catálogo, sucursales). De paso, correr la suite completa contra una base de datos real (ver sección de entorno de tests más abajo) destapó tres bugs reales, ya corregidos:
  - `database/factories/UserFactory.php` no seteaba `last_name` (columna `NOT NULL` propia del proyecto), por lo que cualquier test que creara un `User::factory()` fallaba.
  - `App\Http\Livewire\FooterMenu::mount()` asumía que siempre existe una fila en `upagos_directs` y rompía con un error 500 si la tabla estaba vacía.
  - `App\Actions\Jetstream\DeleteUser::delete()` hacía `$user->update(['trash' => true])` — `trash` no es una columna real de `users` (el borrado de cuenta usa `SoftDeletes`/`deleted_at`, igual que el resto de los modelos del proyecto), así que "eliminar cuenta" no eliminaba nada; se cambió a `$user->delete()`.
- El favicon (`public/favicon.svg` y `public/favicon.ico`) **ya se regeneró** a partir del logo nuevo (commit `0511929`, "Replace favicon with the new MarketPlaza mark") y está referenciado en ambos layouts (`app` y `guest`). La nota en el README quedó desactualizada.
- **Identidad visual actualizada a la paleta/tipografía de rcmwebstudio.** El color de marca (antes índigo, `#4338ca`) pasó a un teal `#0a8a7f`, aliando `theme.extend.colors.indigo` a `colors.teal` en `tailwind.config.js` (evita reescribir las ~88 referencias a clases `indigo-*` en las vistas) y corrigiendo a mano los hex/rgba sueltos en el logo y en el glow de botones/CTAs. La tipografía pasó de Figtree a Inter (texto) y Space Grotesk (marca "MarketPlaza"). El favicon y los 4 componentes de logo (`application-logo`, `application-mark`, `application-sm`, `authentication-card-logo`) se regeneraron con el nuevo color, conservando el mismo carrito-en-círculo — no se adoptó el glifo "R" de rcmwebstudio para no confundir la identidad de negocio de MarketPlaza. Sin cambios funcionales; verificado con `npm run build`, captura visual de `/login`, `/` y `/register`, y la suite completa de tests (36/36 en verde).

## Entorno de tests

`phpunit.xml` no define una base de datos de test aislada (la sección de `sqlite` está comentada). Para no correr `RefreshDatabase` contra la base de datos de desarrollo, se agregó `.env.testing` apuntando a una base `marketplace_testing` separada (mismo servidor MySQL). Al correr los tests dentro del contenedor Docker hace falta forzar el host/nombre de base de datos, porque `docker-compose.yml` ya inyecta `DB_HOST`/`DB_DATABASE` como variables de entorno reales que pisan a `.env.testing`:

```bash
docker compose exec -e DB_HOST=db -e DB_DATABASE=marketplace_testing app php artisan test --env=testing
```
