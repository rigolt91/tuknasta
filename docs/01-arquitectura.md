# Arquitectura general

## Qué es

MarketPlaza es un **marketplace multi-proveedor**: varias sucursales/proveedores (`branches`) publican productos bajo una misma tienda pública. Un cliente navega el catálogo unificado, arma un carrito, hace checkout con pago por tarjeta a través de una pasarela externa (UPagos), y cada proveedor puede ver sus ventas vía reportes en el panel admin.

Es una aplicación Laravel **monolítica server-rendered**: no hay una API pública separada del frontend — el propio backend renderiza Blade + Livewire, y solo existe una API real para el flujo de pago (`routes/api.php`), consumida por JavaScript embebido en la vista de checkout.

## Stack técnico

| Capa | Tecnología |
|---|---|
| Backend | Laravel 10, PHP 8.1 |
| UI reactiva servidor | Livewire 2 (sin build de JS propio — componentes PHP + Blade) |
| Auth / cuentas | Laravel Jetstream 3 (stack `livewire`), Laravel Fortify (2FA obligatorio con confirmación), Laravel Sanctum (guard de sesión) |
| Autorización | Spatie Laravel Permission (roles: `administrator`, `editor`, `customer`) + Policies nativas de Laravel |
| Frontend | Blade, Tailwind CSS 3, Alpine.js 3, Vite |
| Base de datos | MySQL 8 |
| PDF | barryvdh/laravel-dompdf ^3.0 (comprobantes de pedido) |
| Pasarela de pago | UPagos (API REST externa cubana), integrada vía Guzzle + JS del navegador (Elavon 3DS2 SDK) |
| Correo | Laravel Mail + colas (`ShouldQueue`), probado en local con Mailpit |
| Infraestructura dev | Docker Compose: `app` (PHP-FPM), `web` (Nginx), `db` (MySQL 8), `mailpit`, `phpmyadmin`, `node` (Vite dev server) |

## Cómo encajan las piezas

```
Cliente (navegador)
   │
   ├─ Vistas Blade + Livewire (SSR, sin API JSON propia)
   │     ├─ Tienda pública: catálogo, categorías, carrito, detalle de producto
   │     ├─ Checkout: Payment → Delivery → Confirm (wizard de 3 pasos)
   │     ├─ Perfil: mis contactos, mis pedidos
   │     └─ Panel admin (role: administrator|editor): CRUD de catálogo,
   │         proveedores, pedidos, reportes, configuración de pasarela
   │
   └─ JS embebido en la vista de checkout ──▶ routes/api.php (sin auth)
                                                  │
                                                  ▼
                                        PaymentController
                                                  │
                                                  ▼
                                        UPagosDirectService (Guzzle)
                                                  │
                                                  ▼
                                     API externa upagosdirect.com
```

Puntos clave de diseño:

- **No hay separación frontend/backend**: toda la interactividad (filtros, carrito, CRUD admin) se resuelve con Livewire haciendo round-trips al servidor, no con una SPA en JS.
- **El carrito reserva stock de forma optimista**: al agregar un producto al carrito se descuenta el stock inmediatamente (no al pagar), y se restaura si se quita del carrito, se cancela el pedido o se elimina una orden. Ver [02-base-de-datos.md](02-base-de-datos.md) y [07-deuda-tecnica.md](07-deuda-tecnica.md) para el riesgo de carritos abandonados.
- **El pago se confirma desde el cliente**: la orden se crea en base de datos (`payment = true`) cuando el JavaScript del navegador recibe una respuesta exitosa de UPagos y llama de vuelta a un método Livewire — no hay verificación server-side independiente del resultado del pago. Detalle completo en [05-flujo-de-pago.md](05-flujo-de-pago.md).
- **Multi-idioma** (es/en) vía sesión + middleware, sin rutas prefijadas por locale.
- **Multi-proveedor**: cada producto pertenece a un `branch`; el reporte "Ventas en la semana por proveedor" agrupa ventas por `branch_id` a través de los productos vendidos.

Ver el resto de documentos del índice para el detalle de cada capa.
