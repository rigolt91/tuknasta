# Convenciones de Tests — Laravel API REST

## Framework a usar

Detecta cuál usa el proyecto (revisa `composer.json` y la carpeta `tests/`):
- Si hay archivos con sintaxis `it('...', function () {...})` o `test('...', ...)`, el proyecto usa **Pest** — sigue ese estilo.
- Si los tests son clases que extienden `TestCase` con métodos `test_...` o `public function test...()`, es **PHPUnit** clásico — sigue ese estilo.

No mezcles estilos dentro del mismo proyecto. Si el proyecto es nuevo y no hay tests previos, Pest es la opción recomendada por defecto en Laravel moderno, pero confirma con el usuario si no es evidente.

## Qué cubrir por endpoint (mínimo)

Para cada acción de un recurso (index, store, show, update, destroy):

1. **Happy path**: request válida → status code correcto + estructura de respuesta esperada (usa `assertJsonStructure` o el equivalente para no acoplar el test a valores exactos que puedan cambiar).
2. **Validación**: al menos un caso de campo requerido faltante o inválido → 422 con el campo correspondiente en `errors`.
3. **Autorización** (si el recurso tiene Policy): un usuario sin permiso → 403.
4. **No encontrado** (si aplica, ej. show/update/destroy de un id inexistente): → 404.

No es necesario cubrir cada combinación posible de validación — prioriza los casos que reflejan reglas de negocio reales, no cada campo por separado si serían redundantes.

## Datos de prueba

- Usa **factories** de Eloquent (`Model::factory()->create()`) para generar datos, nunca inserts SQL manuales o arrays hardcodeados repetidos en cada test.
- Si un test necesita un estado específico (ej. un pedido ya "enviado"), usa un state de factory (`Model::factory()->enviado()->create()`) en vez de setear el campo manualmente después de crear.

## Ejemplo mínimo (Pest)

```php
it('crea un producto correctamente', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/products', [
            'name' => 'Producto de prueba',
            'price' => 100,
        ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['data' => ['id', 'name', 'price']]);

    $this->assertDatabaseHas('products', ['name' => 'Producto de prueba']);
});

it('rechaza la creación sin nombre', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/products', ['price' => 100]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
});
```

## Base de datos de tests

Usa `RefreshDatabase` (o el trait equivalente que ya use el proyecto) para que cada test corra sobre un estado limpio, salvo que el proyecto tenga una razón deliberada para no hacerlo (ej. tests de integración con una BD compartida — poco común, y debería estar documentado si es el caso).
