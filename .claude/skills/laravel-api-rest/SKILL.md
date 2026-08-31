---
name: laravel-api-rest
description: >
  Implementa backends de API REST en Laravel siguiendo las mejores prácticas del framework: estructura de carpetas estándar, Form Requests para validación, API Resources para las respuestas, Eloquent con relaciones bien definidas, políticas de autorización, manejo de errores consistente, y tests en Pest/PHPUnit para cada endpoint. Usa esta skill SIEMPRE que el usuario pida crear, modificar o revisar un endpoint de API en Laravel, definir un modelo Eloquent, escribir un controlador, una migración, un middleware, o cualquier tarea de desarrollo backend en un proyecto Laravel orientado a API REST (sin Blade/vistas).
---

# Desarrollo Laravel — API REST

Esta skill aplica las convenciones y buenas prácticas de Laravel para construir APIs REST mantenibles, testeables y consistentes. Está pensada para proyectos donde Laravel es puramente el backend (consumido por una web/app aparte), no para proyectos full-stack con Blade o Livewire.

Si llegas a esta skill dentro de la cadena de análisis (idea → requisitos → arquitectura → base de datos → diseño UX/UI → Scrum), usa el documento de arquitectura para confirmar que Laravel/API REST es efectivamente el stack elegido, y el documento de base de datos como fuente de verdad para modelos, campos y relaciones — no los reinterpretes.

## Principios que debe seguir siempre

1. **Controladores delgados.** La lógica de negocio no vive en el controlador. El controlador orquesta: recibe la request ya validada, delega a un Service o Action, y devuelve una respuesta vía Resource. Si un método de controlador supera ~15-20 líneas o mezcla varias responsabilidades, extrae esa lógica.
2. **Validación siempre en Form Requests**, nunca inline en el controlador con `$request->validate()`. Cada endpoint que reciba datos tiene su propio Form Request (ej. `StoreProductRequest`, `UpdateProductRequest`).
3. **Respuestas siempre a través de API Resources** (`JsonResource` / `ResourceCollection`), nunca devolviendo el modelo Eloquent directo o un array armado a mano en el controlador. Esto evita exponer campos sensibles por accidente y mantiene el contrato de la API estable aunque cambie el modelo.
4. **Autorización con Policies**, no con `if` sueltos de rol dentro del controlador. Usa `$this->authorize()` o el middleware `can:`, y define la lógica de permisos en la Policy correspondiente al modelo.
5. **Eloquent con relaciones explícitas y eager loading consciente.** Define las relaciones en el modelo (no consultas manuales con joins salvo que sea necesario por rendimiento). Usa `with()` para evitar N+1 — si un endpoint carga una colección con relaciones, verifica que no haya N+1 antes de darlo por terminado. Para patrones más allá de lo básico (scopes, accessors/mutators, observers, relaciones polimórficas, optimización de consultas grandes, soft deletes), consulta `references/patrones-eloquent.md`.
6. **Manejo de errores consistente.** Usa excepciones específicas (custom exceptions o las de Laravel) y un formato de error uniforme en toda la API (ver `references/manejo-errores.md`). Nunca dejes que un error de servidor se filtre como stack trace en producción.
7. **Migraciones como fuente de verdad del esquema**, siempre con `down()` funcional para poder revertir. Si existe un documento de diseño de base de datos previo, las migraciones deben ser fieles a ese modelo (mismos nombres de tabla/campo salvo razón justificada).
8. **Nombrar según las convenciones de Laravel**: controladores en plural (`ProductController`), rutas en kebab-case (`/api/products/{product}/reviews`), métodos de recursos siguiendo REST estándar (index, store, show, update, destroy).

## Flujo de trabajo

### 1. Entender qué se está construyendo

Si hay documentos previos de la cadena (arquitectura, base de datos), léelos para confirmar el modelo de datos y los endpoints esperados. Si no los hay, trabaja directamente con lo que el usuario describe, pero sigue las convenciones de todas formas.

### 2. Revisar el proyecto existente antes de escribir código

Antes de crear algo nuevo, revisa cómo está organizado el proyecto (estructura de `app/`, si usa Service/Action classes, convenciones ya presentes) para mantener consistencia. No introduzcas un patrón nuevo (ej. Actions) si el proyecto ya usa otro (ej. Services) de forma consistente — sigue lo existente salvo que el usuario pida cambiarlo explícitamente.

### 3. Implementar en el orden correcto

Para una funcionalidad nueva de API REST, el orden natural es:
1. Migración (si hay cambios de esquema)
2. Modelo Eloquent (relaciones, fillable/guarded, casts)
3. Policy (si el recurso requiere autorización)
4. Form Request(s) (validación de entrada)
5. API Resource (formato de salida)
6. Controlador (orquesta lo anterior)
7. Rutas (`routes/api.php`, agrupadas y versionadas si el proyecto ya versiona la API)
8. Tests (ver siguiente sección)

No saltes pasos aunque parezcan triviales (ej. no devuelvas el modelo directo "por ahora" saltándote el Resource) — estas convenciones son las que hacen mantenible el proyecto a mediano plazo.

### 4. Escribir tests junto con el código

Cada endpoint nuevo o modificado debe llevar sus tests, usando el framework de testing que ya use el proyecto (Pest si está configurado, si no PHPUnit clásico). Como mínimo, cubre:
- Caso exitoso (happy path) con la respuesta esperada y su status code correcto (200/201/204)
- Validación fallida (ej. campo requerido ausente → 422)
- Autorización fallida si aplica (ej. usuario sin permiso → 403)
- Caso "no encontrado" si aplica (→ 404)

Usa factories de Eloquent para los datos de prueba, nunca inserts manuales repetidos. Consulta `references/convenciones-tests.md` para la estructura exacta esperada.

### 5. Verificar antes de dar por terminado

- Corre los tests del proyecto relacionados con el cambio (y el linter/formateador si el proyecto lo tiene, ej. Pint).
- Verifica que no haya N+1 evidentes en los endpoints que devuelven colecciones.
- Confirma que ningún campo sensible (contraseñas, tokens) se esté exponiendo en un Resource por descuido.

## Referencias

- `references/estructura-proyecto.md` — organización de carpetas y dónde va cada pieza (Services/Actions, Resources, Policies, etc.)
- `references/manejo-errores.md` — formato uniforme de respuestas de error y excepciones a usar.
- `references/convenciones-tests.md` — estructura y buenas prácticas para los tests de endpoints.
- `references/patrones-eloquent.md` — scopes, accessors/mutators, observers, relaciones avanzadas, optimización de consultas y soft deletes.
- `assets/ejemplo-recurso-completo.md` — ejemplo de referencia de un recurso REST completo (migración → modelo → policy → form requests → resource → controlador → rutas → tests) para un caso simple.
