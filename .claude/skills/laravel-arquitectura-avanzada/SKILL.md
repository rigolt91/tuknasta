---
name: laravel-arquitectura-avanzada
description: >
  Aplica prácticas avanzadas de arquitectura y seguridad en proyectos Laravel API REST que ya usan `laravel-api-rest` y `laravel-avanzado`: versionado de API a largo plazo, seguridad más allá de Form Requests (mass assignment, límites de payload, CORS), comandos Artisan custom para tareas recurrentes, y convenciones de nombres para Jobs/Events/Notifications. Usa esta skill SIEMPRE que el usuario mencione versionar la API (v1/v2), endurecer la seguridad de endpoints existentes, crear un comando Artisan programado, o necesite convenciones de nombres para las piezas cubiertas por `laravel-avanzado`.
---

# Laravel — Arquitectura Avanzada y Seguridad

Esta skill es la tercera pieza del conjunto Laravel, complementaria a `laravel-api-rest` (estructura de endpoints) y `laravel-avanzado` (colas, eventos, caché, rate limiting). Cubre decisiones que normalmente aparecen cuando el proyecto ya tiene tracción: necesita versionarse sin romper clientes existentes, requiere un endurecimiento de seguridad más allá de la validación básica, o necesita automatizar tareas recurrentes.

## Cuándo usarla

- El usuario necesita convivir con múltiples versiones de la API (v1 activa en producción, v2 en desarrollo).
- Se detecta o se quiere prevenir un problema de seguridad más allá de validación de entrada (mass assignment accidental, payload sin límite de tamaño, CORS mal configurado).
- Se necesita un comando Artisan custom para una tarea recurrente (limpieza de datos, sincronización programada, reportes).
- El usuario pregunta cómo nombrar o organizar Jobs, Events, Notifications o Artisan Commands de forma consistente.

Si la tarea es un endpoint CRUD nuevo sin estas necesidades, usa `laravel-api-rest`; si es sobre trabajo en background/eventos/caché, usa `laravel-avanzado`.

## Versionado de API

Cuando el proyecto necesita mantener una v1 en producción mientras desarrolla v2:

```
app/Http/Controllers/Api/V1/ProductController.php
app/Http/Controllers/Api/V2/ProductController.php
app/Http/Resources/V1/ProductResource.php
app/Http/Resources/V2/ProductResource.php
```

```php
Route::prefix('v1')->group(base_path('routes/api_v1.php'));
Route::prefix('v2')->group(base_path('routes/api_v2.php'));
```

- No dupliques toda la lógica de negocio entre versiones — si el Service/Action subyacente no cambió, ambas versiones lo reutilizan; solo el Controller/Resource (la forma de entrada/salida) difiere entre versiones.
- Marca explícitamente cuándo una versión queda deprecada (header `Deprecation` o campo en la documentación) en vez de eliminarla sin aviso.
- No crees v2 completa "por si acaso" — solo cuando hay un cambio real que rompería contratos existentes de v1 (cambio de estructura de respuesta, de reglas de negocio expuestas, etc.). Un campo nuevo opcional no amerita una nueva versión.

## Seguridad más allá de Form Requests

### Mass assignment

`fillable` en el modelo no es suficiente por sí solo si el controlador pasa `$request->all()` directo a `create()`/`update()` — siempre usa `$request->validated()` desde el Form Request, nunca el array crudo de la request, incluso si el modelo ya tiene `fillable` definido.

### Límite de tamaño de payload

Configura límites de tamaño de subida (`post_max_size`, `upload_max_filesize` en PHP, y validación de tamaño en el Form Request con la regla `max:` en KB para archivos) para evitar que un cliente envíe payloads desproporcionados.

### CORS

Revisa `config/cors.php`: en producción, `allowed_origins` debe ser una lista explícita de dominios permitidos, nunca `*` si la API maneja datos autenticados (con `*` + credenciales, algunos navegadores ya lo rechazan, pero además es una mala práctica de seguridad independientemente).

### Headers de seguridad

Si el proyecto no usa un paquete específico para esto, al menos confirma que respuestas de error no filtren información del framework/versión más de lo necesario, y que headers sensibles (tokens, cookies de sesión si aplica) tengan flags `HttpOnly`/`Secure` correctos en el entorno de producción.

## Comandos Artisan custom

Para tareas recurrentes (limpieza, sincronización, reportes programados):

```php
class CleanExpiredTokens extends Command
{
    protected $signature = 'app:clean-expired-tokens';
    protected $description = 'Elimina tokens de acceso expirados';

    public function handle(): void
    {
        $count = PersonalAccessToken::where('expires_at', '<', now())->delete();
        $this->info("Se eliminaron {$count} tokens expirados.");
    }
}
```

- Nombra el comando con un prefijo del dominio de la app (`app:`) para distinguirlo de los comandos nativos de Laravel.
- Si la tarea debe correr con frecuencia, regístrala en el scheduler (`routes/console.php` en Laravel 11+, o el método `schedule()` del Kernel en versiones anteriores) en vez de depender de que alguien la ejecute manualmente.
- Un comando que puede fallar a mitad de proceso (ej. procesar muchos registros) debe ser reentrante — que correrlo dos veces no duplique efectos.

## Convenciones de nombres (Jobs, Events, Notifications, Commands)

| Tipo | Convención | Ejemplo |
|------|-----------|---------|
| Job | Verbo + sustantivo, en imperativo | `ProcessOrderExport`, `SendWeeklyReport` |
| Event | Sustantivo + verbo en pasado (algo que ya ocurrió) | `OrderCreated`, `PaymentFailed` |
| Listener | Acción que responde al evento | `SendOrderConfirmation`, `NotifyAdminOfFailure` |
| Notification | Sustantivo describiendo el mensaje | `OrderConfirmed`, `PasswordResetRequested` |
| Artisan Command | Prefijo de dominio + acción | `app:clean-expired-tokens` |

Mantener esta distinción (Event = algo que pasó, Job = algo que hay que hacer) evita confusión sobre cuál usar en cada caso: si ya ocurrió algo y varios efectos independientes deben reaccionar, es un Event; si es una sola tarea que se quiere diferir, es un Job directo.

## Referencias

- `references/checklist-seguridad.md` — checklist rápido de seguridad a revisar antes de exponer una API a producción.
