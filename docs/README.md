# Documentación técnica — MarketPlaza

Este directorio documenta el proyecto MarketPlaza a partir de la exploración completa del código fuente (modelos, migraciones, rutas, controladores, componentes Livewire, vistas, infraestructura). Es documentación **derivada del código actual**, no una especificación aparte — si el código cambia, estos documentos pueden quedar desactualizados y deben revisarse.

## Índice

1. [Arquitectura general](01-arquitectura.md) — visión de conjunto, stack técnico, cómo encajan las piezas.
2. [Base de datos y modelos](02-base-de-datos.md) — todas las tablas, columnas, relaciones Eloquent y reglas de negocio del modelo de datos.
3. [Rutas, controladores y autenticación](03-rutas-y-autenticacion.md) — mapa de rutas por área, controladores, middleware, roles/permisos, Jetstream/Fortify/Sanctum.
4. [Componentes Livewire](04-livewire.md) — inventario y responsabilidad de los ~70 componentes Livewire, organizados por área funcional.
5. [Flujo de pago (checkout)](05-flujo-de-pago.md) — paso a paso de la integración con la pasarela externa UPagos, incluyendo los riesgos de seguridad detectados.
6. [Frontend, i18n, PDF, correo e infraestructura](06-frontend-e-infraestructura.md) — vistas Blade, cambio de idioma, generación de comprobantes PDF, correos transaccionales, Docker Compose, build de Tailwind/Vite.
7. [Deuda técnica y hallazgos](07-deuda-tecnica.md) — inconsistencias, código vestigial y riesgos encontrados durante la exploración, para tener en cuenta antes de tocar esas áreas.

## Cómo se generó esta documentación

Se exploró el repositorio completo el 2026-08-31 partiendo del [README.md](../README.md) del proyecto: 26 migraciones, 19 modelos Eloquent, 4 controladores, ~70 componentes Livewire, middleware, policies, configuración de Jetstream/Fortify/Sanctum/Spatie Permission, vistas Blade, archivos de idioma, Dockerfile/docker-compose y tests existentes.
