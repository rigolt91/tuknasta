# Rutas, controladores y autenticación

## Rutas (`routes/web.php`, middleware `web`)

### Tienda pública (sin autenticación)

| Ruta | Componente/vista |
|---|---|
| `GET /` | `WelcomeComponent` (home, nombre de ruta `dashboard`) |
| `GET /products/{search?}` | `DashboardComponent` (listado/búsqueda/filtro de catálogo) |
| `GET /product/details/{slug}` | `ProductDetailComponent` |
| `GET /wholesaler` | `WholesalerComponent` (formulario B2B mayoristas) |
| `GET /about-us`, `/customer-support`, `/return-policy`, `/delivery-policy`, `/terms`, `/policy` | vistas Blade estáticas |
| `GET /greeting/{locale}` | closure — guarda `locale` en sesión (cambio de idioma) |

### Checkout y perfil (middleware `auth:sanctum`, `user.enabled`, sesión Jetstream, `verified`)

| Ruta | Componente |
|---|---|
| `GET /cart/cart-details` | `CartDetailComponent` |
| `GET /payment` | `PaymentComponent` (paso 1: elegir dirección) |
| `GET /payment/delivery` | `DeliveryComponent` (paso 2: método de entrega) |
| `GET /payment/confirm/{method?}` | `ConfirmComponent` (paso 3: confirmación y pago) |
| `GET /profile/my-orders` | `MyOrderComponent` |

Las rutas de login/registro/2FA/perfil de Jetstream **no están en `web.php`** — las registra automáticamente Fortify/Jetstream vía sus propios service providers.

### Panel admin (mismo stack de middleware + `role:` de Spatie)

- `role:administrator|editor`: `/admin-panel`, `/admin-panel/products`, `/categories`, `/subcategories`, `/orders`, reportes (`sales-in-the-week-by-supplier`, `daily-sales`, `weekly-sales`, `monthly-sales`, `year-sales`), `/admin-panel/users`.
- `role:administrator` (más restrictivo): `/admin-panel/rate-transportation`, `/admin-panel/branches`, `/admin-panel/sliders`, `/admin-panel/upagosdirect` (configuración de la pasarela de pago y datos de contacto del sitio).

### `routes/api.php` (middleware `api`, stateless, **sin sesión/CSRF**)

```
POST /api/validateform  → PaymentController@validateForm
GET  /api/efstoken      → PaymentController@getToken
POST /api/verify        → PaymentController@verify
POST /api/sale          → PaymentController@sale
GET  /api/user (auth:sanctum) → usuario autenticado
```

**Importante**: las 4 rutas de pago no tienen `auth:sanctum` ni ninguna otra protección — solo el limitador `throttle:api` del grupo `api`. Ver [05-flujo-de-pago.md](05-flujo-de-pago.md) para el detalle del riesgo.

### `routes/channels.php`

Canal privado `App.Models.User.{id}`, autoriza solo si `$user->id === $id` (broadcasting por usuario).

### `routes/console.php`

Sin comandos custom, solo el `inspire` de ejemplo de Laravel.

## Controladores

- **`Controller.php`** — base abstracta estándar (`AuthorizesRequests`, `ValidatesRequests`).
- **`LaravelChart.php`** — no es un controlador HTTP; genera datasets/gráficos Chart.js para los reportes del panel admin (agrupación dinámica por fecha/relación, filtros por período).
- **`PaymentController.php`** — fachada delgada sobre `UPagosDirectService`: valida el formulario de tarjeta (`validateForm`), obtiene el token 3DS2 (`getToken`), y reenvía verificación/venta (`verify`, `sale`) tal cual al servicio.
- **`UPagosDirectService.php`** — cliente Guzzle hacia `https://www.upagosdirect.com/api/`, con `Authorization: Bearer <token>` (token guardado en `upagos_directs` o en `config('services.upagos.token')` como fallback) y `verify => false` (SSL sin verificar).

## Middleware custom

| Middleware | Alias/uso | Qué hace |
|---|---|---|
| `Localization` | global en grupo `web` | Si `session('locale')` existe, `App::setLocale(...)`. |
| `UserEnabled` | `user.enabled` | Si el usuario está bloqueado/eliminado, redirige a `login`. Protege carrito, pago, perfil y admin. |
| `Authenticate` | `auth` | Estándar, redirige a `login` si no hay sesión. |
| `RedirectIfAuthenticated` | `guest` | Estándar Jetstream. |
| `EncryptCookies`, `TrimStrings`, `TrustHosts`, `TrustProxies`, `ValidateSignature`, `VerifyCsrfToken`, `PreventRequestsDuringMaintenance` | — | Stubs estándar de Laravel sin personalización relevante. |

## Roles, permisos y policies

- Paquete **Spatie Laravel Permission**, sin "teams". Roles: `administrator`, `editor`, `customer`.
- **`UserContactPolicy`**: `update`/`delete` de un contacto solo si `$user->id === $userContact->user_id`.
- **`UserRolePolicy`**: reutilizada para `Branch`, `Category`, `Subcategory`, `Product`, `Order`, `Report`, `RateTransportation` — `create`/`update`/`delete` solo si el usuario tiene rol `administrator` o `editor`.
- El middleware `role:` de Spatie protege las rutas web del admin (ver tabla de rutas arriba); es la primera línea de defensa, reforzada por las policies dentro de los componentes Livewire (`AuthorizesRequests`).

## Autenticación (Jetstream + Fortify + Sanctum)

- **Jetstream**: stack `livewire`, guard `sanctum`, `auth_session = AuthenticateSession` (invalida sesión si cambia el hash de password). Activo: términos y condiciones al registro, eliminación de cuenta. Desactivado: fotos de perfil propias de Jetstream (se usa un flujo custom), tokens API de Jetstream, teams.
- **Fortify**: guard `web`, username = `email`. Activo: registro, reset de password, verificación de email, actualización de perfil/password, **2FA obligatorio con confirmación** (`confirm: true, confirmPassword: true`). Rate limiting: login 5/min (email+IP), 2FA 5/min por sesión. Acciones custom en `app/Actions/Fortify/`.
- **Sanctum**: guard `web`, dominios stateful por defecto, sin expiración de tokens.
- El acceso protegido combina siempre: `auth:sanctum` + `user.enabled` + sesión Jetstream + `verified` (email verificado), y en el admin además `role:`.

## Providers relevantes

- **`AuthServiceProvider`**: registra el mapeo de policies mencionado arriba.
- **`RouteServiceProvider`**: `HOME = '/'`; rate limiter `api` (60/min por usuario o IP).
- **`FortifyServiceProvider`**: conecta las acciones custom y define los rate limiters `login`/`two-factor`.
- Existe un evento de dominio **`AddProductCart`** con listener en cola **`RemoveProductAfterFewMinutes`** (`ShouldQueue`, `delay = 1800` = 30 min, `tries = 2`): al agregar un producto al carrito se programa este job, que tras 30 minutos elimina la línea de carrito y restaura el stock si el usuario no completó la compra — es el mecanismo real detrás de la reserva optimista de stock (ver [02-base-de-datos.md](02-base-de-datos.md) y [07-deuda-tecnica.md](07-deuda-tecnica.md)).
