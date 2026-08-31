# Manejo de Errores — Laravel API REST

## Formato de respuesta de error uniforme

Toda respuesta de error de la API debe seguir la misma forma, para que el cliente (web/app) pueda manejarlas de manera predecible:

```json
{
  "message": "Descripción legible del error",
  "errors": {
    "campo": ["mensaje de validación específico"]
  }
}
```

- `errors` solo aparece en errores de validación (422). Para el resto de errores, basta con `message` (y opcionalmente un campo `code` interno si el proyecto ya lo usa).
- Configura esto centralizado en el manejador de excepciones de Laravel (`bootstrap/app.php` en Laravel 11+, o `app/Exceptions/Handler.php` en versiones anteriores) para que aplique de forma consistente sin repetir lógica en cada controlador.

## Códigos de estado esperados

| Situación | Código |
|-----------|--------|
| Éxito con contenido | 200 |
| Recurso creado | 201 |
| Éxito sin contenido (ej. destroy) | 204 |
| Validación fallida | 422 |
| No autenticado | 401 |
| Autenticado pero sin permiso | 403 |
| Recurso no encontrado | 404 |
| Conflicto (ej. estado inválido para la operación) | 409 |
| Error de servidor no esperado | 500 |

## Excepciones custom de dominio

Cuando una regla de negocio falla de forma esperada (ej. "no se puede cancelar un pedido ya enviado"), lanza una excepción custom específica (ej. `PedidoNoCancelableException`) en vez de un `abort(400, '...')` genérico. Esto permite:
- Capturarla específicamente donde se necesite.
- Mapearla a un código de estado y mensaje consistente desde el manejador central de excepciones.

## Nunca exponer detalles internos en producción

- Con `APP_DEBUG=false`, Laravel ya oculta el stack trace por defecto — no lo desactives ni lo reemplaces por un manejo custom que sí lo exponga.
- No incluyas mensajes de excepciones de base de datos crudos (ej. el mensaje de un `QueryException`) directamente en la respuesta al cliente — tradúcelos a un mensaje genérico y registra el detalle real en los logs (`Log::error()`).
