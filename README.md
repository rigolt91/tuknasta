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

- El `composer.lock` tiene dependencias con CVEs conocidas (incluye una vulnerabilidad crítica en `dompdf`); antes de exponer este proyecto como demo pública en vivo, conviene actualizar dependencias.
- El favicon se generó a partir del logo original del cliente; se puede regenerar a partir del nuevo logo SVG en `resources/views/components/`.

## Licencia

Proyecto de portafolio con fines demostrativos.
