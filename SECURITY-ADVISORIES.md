# Advisories de seguridad pendientes (Composer)

Generado con `composer audit --locked` el 2026-08-11. Este documento es un registro de trabajo pendiente, no una corrección — nada de esto se aplicó todavía.

Cómo regenerar esta lista: `composer audit --locked`

## Resumen priorizado

### 1. Arreglables ya, sin cambios que rompan nada (`composer update <paquete>` dentro de los rangos actuales de `composer.json`)

| Paquete | Versión actual | Versión mínima segura | CVE / Advisory | Severidad |
|---|---|---|---|---|
| guzzlehttp/guzzle | 7.7.0 | 7.15.2 | CVE-2026-69246, CVE-2026-69245, CVE-2026-67354/67355/67353, CVE-2026-59883, CVE-2026-67339, CVE-2026-55767, CVE-2026-55568 | alta (la peor) |
| guzzlehttp/psr7 | 2.6.0 | 2.12.3 | CVE-2026-59882, CVE-2026-55766, CVE-2026-49214, CVE-2026-48998 | media |
| livewire/livewire | v2.12.6 | 2.12.7 | CVE-2024-47823 (RCE por subida de archivos) | alta |
| phpunit/phpunit | 10.3.1 | 10.5.62 | CVE-2026-24765 (deserialización insegura) | alta (solo dev) |
| nesbot/carbon | 2.68.1 | 2.72.6 | CVE-2025-22145 (include arbitrario de archivo) | media |
| psy/psysh | v0.11.20 | 0.11.23 | CVE-2026-25129 (escalada de privilegios local) | media (solo dev) |
| symfony/mailer | v6.3.0 | 6.4.40 | CVE-2026-45068 (inyección de argumentos) | media |
| symfony/process | v6.3.2 | 6.4.14 | CVE-2024-51736 (hijack de comandos en Windows) | alta |
| symfony/routing | v6.3.3 | 6.4.41 | CVE-2026-48784, CVE-2026-45065 | media |
| symfony/yaml | v6.3.3 | 6.4.40 | CVE-2026-45304/45305/45133 (DoS) | baja |
| dompdf/dompdf | v2.0.3 | 2.0.8 (parche parcial, sigue en la rama 2.x) | PKSA-qsyb-3psh-f1t3 vía phenx/php-svg-lib (RCE crítico) | **crítica** |

**Acción recomendada:** correr un `composer update` acotado a este grupo de paquetes (con `--with-all-dependencies`) y fijar `config.platform.php` a la versión de PHP de la imagen Docker (8.1.34) como se hizo para el fix de `laravel-lang`. Ninguno de estos requiere subir de versión mayor ni tocar `composer.json` más allá de lo que ya está.

### 2. Requieren trabajo mayor (cambio de versión mayor, con posibles breaking changes)

| Paquete | Versión actual | Fix completo requiere | Qué implica |
|---|---|---|---|
| dompdf/dompdf | v2.0.3 | **3.1.6+** | Six CVEs de 2026 (lectura de archivos vía SVG, DoS por bitmaps/BMP) solo se resuelven en dompdf 3.x. Requiere subir `barryvdh/laravel-dompdf` de `^2.0` a `^3.0` en `composer.json` — revisar su changelog por cambios de API antes de actualizar. |
| laravel/framework | v10.18.0 | **12.61.1+ o 13.10/13.12+** | Dos advisories (confusión de rutas en Signed URLs, inyección CRLF en la regla de validación de email) solo están parcheadas en Laravel 12.61.1+ o 13.x. Laravel 10 ya no recibe backport de seguridad para estos. Implica migrar 10 → 11 → 12 → 13, siguiendo las guías de upgrade oficiales de cada major — proyecto aparte, con su propio plan de pruebas. |

Nota: dentro de la rama actual de `laravel/framework` (^10.0) sí se pueden resolver dos de los cinco advisories con un update simple a 10.48.29+:
- CVE-2025-27515 (bypass de validación de archivos)
- CVE-2024-52301 (manipulación de entorno vía query string)

Se recomienda aplicar ese update de mantenimiento dentro de 10.x como mitigación inmediata, y planear la migración mayor de Laravel por separado.

## Contexto

Esta lista salió del `composer audit` corrido después de arreglar el bloqueo de instalación por malware en `laravel-lang/*` (paquetes comprometidos en un ataque real a la cadena de suministro, mayo 2026). No estaba relacionado con el malware — son advisories de seguridad normales acumuladas por versiones desactualizadas del lock file.
