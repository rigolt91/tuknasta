# MarketPlaza

MarketPlaza es un marketplace de e-commerce multi-proveedor construido con **Laravel 10** y **Livewire**. Permite a varios proveedores/sucursales publicar su catálogo bajo una misma tienda, con carrito de compras, checkout con pasarela de pago externa, panel de administración con roles y permisos, y reportes de ventas por proveedor.

> **Nota sobre este repositorio.** Este proyecto se desarrolló originalmente como un trabajo freelance real para un cliente de e-commerce. Para esta versión de portafolio se genericen la marca, los datos de contacto y las credenciales de acceso por motivos de confidencialidad; toda la funcionalidad original se mantiene intacta.

## Funcionalidades

**Tienda pública**
- Catálogo de productos organizado por categorías y subcategorías, con búsqueda.
- Carrito de compras y checkout con selección de método de entrega.
- Integración con pasarela de pago externa (tarjeta de crédito/débito).
- Sección para compras al por mayor (mayoristas) con formulario de contacto.
- Páginas de políticas, términos y condiciones, y soporte al cliente.
- Interfaz multi-idioma (español / inglés).
- Perfil de cliente con historial e información de contacto.

**Panel de administración**
- Gestión de sucursales/proveedores (incluyendo sub-proveedores).
- Gestión de categorías, subcategorías y productos.
- Gestión de pedidos y estados de orden.
- Gestión de tarifas de transporte por zona.
- Configuración de la pasarela de pago.
- Gestión de usuarios con roles y permisos (Spatie Permission).
- Reportes de ventas: diario, semanal, mensual, anual y semanal por proveedor.
- Generación de comprobantes en PDF (dompdf).
- Autenticación en dos pasos (2FA) vía Laravel Fortify/Jetstream.

## Stack técnico

- **Backend:** Laravel 10, Livewire 2, Laravel Jetstream, Laravel Sanctum
- **Autorización:** Spatie Laravel Permission (roles y permisos)
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Base de datos:** MySQL 8
- **PDF:** barryvdh/laravel-dompdf
- **Infraestructura de desarrollo:** Docker Compose (app PHP-FPM, Nginx, MySQL, Mailpit, phpMyAdmin)

## Puesta en marcha con Docker

```bash
git clone <url-del-repositorio>
cd marketplace
cp .env.example .env

docker compose up -d
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec node npm install
docker compose exec node npm run build
```

La aplicación quedará disponible en `http://localhost:8081`, phpMyAdmin en `http://localhost:8082` y Mailpit (para revisar los correos enviados en local) en `http://localhost:8025`.

### Credenciales de demo

Generadas por los seeders, **solo para revisión local**:

- Usuario administrador: `admin@marketplace.example.com` / `Demo12345!`

### Instalación sin Docker

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# configurar DB_* en .env apuntando a tu MySQL local
php artisan migrate --seed
npm run build
php artisan serve
```

## Pendientes conocidos (fuera del alcance de esta limpieza)

- Las dependencias de Composer se actualizaron a la última versión de parche/minor dentro de sus majors actuales (Laravel `^10.0`, Livewire `^2.11`, Guzzle, Symfony vía `illuminate/*`, PHPUnit, etc. — ver `composer.lock`). Con eso, `composer audit` pasó de 29 advisories en 11 paquetes a solo 3, todos en `laravel/framework`, y esos tres **solo tienen fix en Laravel 12.60+/13.10+** — no hay parche disponible dentro de la línea 10.x. Quedan documentados e ignorados explícitamente en `composer.json` (`config.audit.ignore` / `config.policy.advisories.ignore-id`) para no bloquear `composer update` futuros. Migrar a Laravel 12/13 y Livewire 3.x sigue fuera de alcance: es un cambio de API mayor (Livewire 3 cambia `emit`→`dispatch`, `wire:model`, etc. en prácticamente todos los componentes) y requeriría una migración dedicada con pruebas exhaustivas. La vulnerabilidad crítica que había en `dompdf` (RCE vía `phenx/php-svg-lib`) ya estaba corregida en `composer.lock`, pero el contenedor de desarrollo tenía un `vendor/` desincronizado (volumen Docker con caché vieja) que seguía sirviendo la versión vulnerable — correr `composer install` lo sincronizó.
- Las dependencias de npm (`devDependencies`, herramientas de build) se actualizaron con `npm audit fix` (sin cambios breaking): de 15 a 4 vulnerabilidades restantes, todas en la cadena de `vite`/`esbuild` y solo resolubles con un salto de major de Vite (breaking). `npm audit --production` reporta 0 vulnerabilidades — nada de esto llega al bundle final.

## Licencia

Proyecto de portafolio con fines demostrativos.
