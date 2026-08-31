# Checklist de Seguridad — Laravel API REST

Revisa esto antes de considerar un endpoint o el proyecto completo listo para producción.

## Entrada de datos

- [ ] ¿Todo endpoint que recibe datos usa un Form Request con `validated()`, nunca `$request->all()` directo a `create()`/`update()`?
- [ ] ¿Los modelos tienen `fillable` (o `guarded` explícito) definido, sin depender solo de la validación externa?
- [ ] ¿Los uploads de archivos tienen límite de tamaño y tipo validado (`max:`, `mimes:`)?

## Autenticación y autorización

- [ ] ¿Cada endpoint que debería requerir autenticación está dentro de un grupo con middleware `auth:sanctum` (u otro)?
- [ ] ¿Cada acción sobre un recurso propio de un usuario (update/delete) pasa por una Policy, no solo por estar autenticado?

## Configuración de producción

- [ ] ¿`APP_DEBUG=false` en producción?
- [ ] ¿`config/cors.php` tiene `allowed_origins` explícito (no `*`) si la API maneja sesiones o tokens?
- [ ] ¿Las cookies de sesión (si aplica) tienen `Secure` y `HttpOnly` activados en producción?

## Límites de uso

- [ ] ¿Los endpoints sensibles (login, recuperación de contraseña, uploads) tienen rate limiting más estricto que el resto?

## Versionado (si aplica)

- [ ] Si existe más de una versión de la API, ¿la versión antigua tiene un plan/aviso de deprecación en vez de mantenerse indefinidamente sin comunicación?
