# Estructura de Proyecto — Laravel API REST

## Organización recomendada dentro de `app/`

```
app/
  Http/
    Controllers/Api/        # Un controlador por recurso, dentro de un namespace Api
    Requests/                # Form Requests, uno por acción que valida (Store, Update)
    Resources/               # API Resources y ResourceCollections
    Middleware/
  Models/                    # Modelos Eloquent
  Policies/                  # Policies de autorización, una por modelo protegido
  Services/                  # Lógica de negocio que no encaja en un método corto de modelo/controlador
  Exceptions/                # Excepciones custom de dominio
```

Si el proyecto ya usa **Actions** (una clase por caso de uso, ej. `CreateProductAction`) en vez de Services, sigue ese patrón existente — no mezcles ambos estilos en el mismo proyecto sin que el usuario lo pida.

## Cuándo usar Service/Action vs. lógica directa en el modelo

- **Directo en el modelo (scope, accessor, método simple)**: cuando la lógica es puramente sobre los datos de ese modelo (ej. `scopeActive()`, un accessor calculado).
- **Service/Action**: cuando la operación involucra varios modelos, llamadas externas, o varios pasos con posible fallo parcial (ej. crear un pedido que también descuenta stock y genera un pago).

## Rutas (`routes/api.php`)

- Agrupa por recurso con `Route::apiResource()` cuando el endpoint sigue el CRUD estándar.
- Usa prefijos de versión si el proyecto ya versiona la API (`/api/v1/...`); si es un proyecto nuevo sin versión definida, pregunta al usuario si conviene empezar versionado desde ya (suele ser más fácil que agregarlo después).
- Agrupa middleware de autenticación (`auth:sanctum` u otro) a nivel de grupo de rutas, no repetido por ruta individual.

## Autenticación

Para APIs REST, Laravel Sanctum es la opción estándar y la que debes asumir por defecto salvo que el documento de arquitectura indique otra cosa (ej. Passport para OAuth2 completo, o un proveedor externo).
