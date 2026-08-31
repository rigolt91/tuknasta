# Frontend, i18n, PDF, correo e infraestructura

## Vistas y layouts

`resources/views/` está organizado por área:

- **`layouts/`** — `app.blade.php` (layout autenticado/principal) y `guest.blade.php` (minimalista, para auth).
- **`components/`** — componentes Blade reutilizables heredados del scaffolding de Jetstream (botones, inputs, modal, tablas, dropdowns, iconos SVG).
- **`livewire/`** — la mayoría de la UI de negocio, reflejando la estructura de `app/Http/Livewire/`: `admin-panel/` (con subcarpetas por área), `cart/`, `category/`, `payment/` (con `steps/`), `product/`, `profile/{my-contact,my-order}/`.
- **`emails/`** — `order-shipped.blade.php`, `team-invitation.blade.php`, `wholesaler.blade.php`.
- **`auth/`, `profile/`, `policy/`** (términos, devoluciones, soporte), **`api/`**, **`charts/`**.
- Vistas sueltas en raíz: `about-us.blade.php`, `dashboard-component.blade.php`, `navigation-menu.blade.php`, `navigation-menu-sm.blade.php`, `footer-menu.blade.php`, `welcome-component.blade.php`.

**`layouts/app.blade.php`**: `@vite(['resources/css/app.css', 'resources/js/app.js'])` + script legado `js/site.js` + Toastify (CDN); incluye `@livewire('navigation-menu')`, slot de `$header`, `$slot` principal, `@livewire('livewire-ui-modal')` (paquete de modales usado por `ShowComponent`, `OrderComponent`, etc.), `@livewire('footer-menu')`, botón "volver arriba" y overlay de carga (`#loadding`).

**`app/View/Components/{AppLayout,GuestLayout}.php`**: componentes triviales, solo `return view('layouts.app'|'guest')` — el patrón estándar `<x-app-layout>`/`<x-guest-layout>` de Jetstream.

## Internacionalización (es/en)

- `lang/en/` y `lang/es/` — archivos estándar de Laravel (`auth`, `http-statuses`, `pagination`, `passwords`, `validation`).
- `lang/en.json` / `lang/es.json` — traducciones de strings libres vía `__('texto')`, con equivalentes específicos del dominio (estados de pedido, "Sales in the Week by Supplier", etc.).
- **Flujo de cambio de idioma**:
  1. `GET /greeting/{locale}` (ruta nombrada `app.lang`) guarda `session()->put('locale', $locale)` y redirige atrás.
  2. Middleware global `Localization` hace `App::setLocale(session('locale'))` en cada request.
  3. `LangApp` (Livewire) expone `App::currentLocale()`; su vista muestra un selector con banderas y enlaces a `route('app.lang', 'es'|'en')`.
- Solo dos idiomas soportados, sin prefijo de ruta por locale.

## Generación de PDF (barryvdh/laravel-dompdf)

Dos usos, ambos en el panel admin de pedidos, ambos accionados manualmente desde la UI (no hay generación automática por evento):

- `AdminPanel/Order/ShowComponent::generatePDF()` — comprobante de una orden individual (`livewire.admin-panel.order.print`), descargado como `{numero}.pdf` vía `streamDownload`.
- `AdminPanel/Order/OrderComponent::generatePDFOrders()` — listado de órdenes filtradas (`livewire.admin-panel.order.print-orders`), descargado como `Orders.pdf`.

## Correo electrónico

Ambos Mailables implementan `ShouldQueue` (se envían por cola, no de forma síncrona):

- **`App\Mail\OrderShipped`** — recibe el `UserOrder`, vista `emails.order-shipped`. Se dispara desde `Payment\ConfirmComponent::paymentConfirm()` al confirmar la compra: `Mail::to($user)->cc($contact)->bcc(config('mail.from.address'))`.
- **`App\Mail\Wholesaler`** — recibe `subject`, `email`, `message`; `from` = la dirección del remitente del formulario público. Se dispara desde `WholesalerComponent::store()` hacia `config('mail.from.address')`, con manejo de errores vía try/catch y `session()->flash('message', ...)`.

En desarrollo, el correo se prueba con **Mailpit** (SMTP en `mailpit:1025`, UI web en `http://localhost:8025`).

## Infraestructura Docker

**`Dockerfile`**: `php:8.1-fpm` + extensiones (`gd`, `pdo_mysql`, `bcmath`, `intl`, `zip`, `opcache`) + Composer 2; expone el puerto 9000 (PHP-FPM), sin servidor web propio.

**`docker-compose.yml`** — servicios:

| Servicio | Imagen | Puerto host | Rol |
|---|---|---|---|
| `app` | build local | — | PHP-FPM, monta el código + volúmenes nombrados para `vendor`/`node_modules` |
| `web` | `nginx:stable-alpine` | `8081→80` | Sirve la app, `fastcgi_pass app:9000` |
| `db` | `mysql:8.0` | `3306` | Base de datos `marketplace`, root sin password, volumen `dbdata` |
| `mailpit` | `axllent/mailpit` | `8025` (UI), `1025` (SMTP) | Captura de correo local |
| `phpmyadmin` | — | `8090→80` | Administración de `db` |
| `node` | `node:18` | `5173` | Vite dev server (HMR), contenedor idle, se opera vía `docker exec` |

`nginx/default.conf`: server simple en puerto 80, `root /var/www/html/public`, headers de seguridad básicos (`X-Frame-Options`, `X-Content-Type-Options`), bloqueo de archivos `.ht*`.

## Frontend build

- **Tailwind** (`tailwind.config.js`): `content` cubre vistas de Jetstream, paginación, `wire-elements/modal`, `storage/framework/views` y todo el proyecto. Fuente `Figtree`. Plugins `@tailwindcss/forms`, `@tailwindcss/typography`.
- **Vite** (`vite.config.js`): entradas `resources/css/app.css` y `resources/js/app.js`; el `refresh` incluye `app/Http/Livewire/**` para hot-reload al editar componentes PHP. Server en `0.0.0.0:5173`, HMR apuntando a `localhost` (coherente con el contenedor `node`).
- **`package.json`**: scripts `dev`/`build` (Vite). Dependencias: `alpinejs` (+ plugin `focus`), `axios`, `tailwindcss` — sin Vue/React, stack ligero acorde a Livewire.

## Tests

`tests/Feature/` cubre casi exclusivamente el scaffolding de Jetstream/Fortify heredado: autenticación, registro, reset/confirmación de password, verificación de email, 2FA, sesiones de navegador, borrado de cuenta, información de perfil, tokens de API. `tests/Unit/ExampleTest.php` es el placeholder por defecto de Laravel.

**No hay tests de Feature para la lógica de negocio propia del marketplace** (carrito, checkout/pago, órdenes, generación de PDF, envío de `OrderShipped`/`Wholesaler`, panel admin, localización) — toda la cobertura existente viene del scaffolding, no del dominio custom. Ver [07-deuda-tecnica.md](07-deuda-tecnica.md).
