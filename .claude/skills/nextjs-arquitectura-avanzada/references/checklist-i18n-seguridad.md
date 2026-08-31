# Checklist de i18n y Seguridad — Next.js

Revisa esto antes de considerar la app lista para producción si maneja múltiples idiomas y/o necesita headers de seguridad endurecidos.

## Internacionalización

- [ ] ¿Todos los textos visibles vienen de archivos de traducción, sin strings hardcodeados en componentes?
- [ ] ¿`generateMetadata` devuelve título/descripción traducidos según el locale de la ruta?
- [ ] ¿Existe un locale por defecto claro y un fallback si el idioma solicitado no está soportado?
- [ ] ¿Fechas, números y monedas se formatean según el locale (no hardcodeados en formato de un solo idioma)?

## Headers de seguridad

- [ ] ¿`next.config.js` define al menos `X-Frame-Options`, `X-Content-Type-Options` y `Referrer-Policy`?
- [ ] ¿Existe una Content-Security-Policy configurada (no ausente por completo)?
- [ ] Si se endureció el CSP en un proyecto ya en producción, ¿se probó primero en modo `Report-Only`?

## Server Actions

- [ ] ¿Cada Server Action que muta datos sensibles revalida sesión/permisos dentro de sí misma, sin depender solo de que la UI oculte el botón?
- [ ] ¿Las Server Actions costosas o sensibles (envío de emails, generación de recursos) tienen algún límite de uso (rate limiting)?

## Runtime

- [ ] ¿El middleware evita depender de APIs no disponibles en Edge Runtime?
- [ ] ¿Los Route Handlers que requieren librerías Node-only (ORMs tradicionales, SDKs pesados) están explícitamente en Node.js Runtime, no en Edge?
