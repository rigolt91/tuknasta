# Convenciones de Tests — Livewire

## Herramienta

Usa el helper `Livewire::test()` (funciona con Pest o PHPUnit, detecta cuál usa el proyecto igual que en `laravel-api-rest`). No se necesita un navegador real ni JavaScript — Livewire simula el ciclo de request/render en el test.

## Qué cubrir por componente

1. **Renderizado inicial correcto** — el componente monta con las propiedades esperadas.
2. **Interacción principal (happy path)** — `set()` + `call()` del método principal produce el resultado esperado (dato guardado, evento disparado).
3. **Validación fallida** — un valor inválido produce el error esperado en el campo correcto.
4. **Autorización** (si aplica) — un usuario sin permiso no puede ejecutar la acción protegida.
5. **Eventos** — si el componente dispara o escucha eventos, verifica que ocurra (`assertDispatched`) o que reaccione correctamente al recibirlo (`Livewire::test(Componente::class)->call('metodoQueEscuchaElEvento')` o disparando el evento desde otro test según el caso).

## Ejemplo completo (Pest)

```php
it('monta con los productos del usuario autenticado', function () {
    $user = User::factory()->create();
    Product::factory()->for($user)->count(3)->create();

    Livewire::actingAs($user)
        ->test(ProductIndex::class)
        ->assertSee('3 productos');
});

it('valida el precio negativo', function () {
    Livewire::test(CreateProduct::class)
        ->set('form.name', 'Silla')
        ->set('form.price', -10)
        ->call('save')
        ->assertHasErrors(['form.price' => 'min']);
});

it('impide editar un producto ajeno', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $product = Product::factory()->for($owner)->create();

    Livewire::actingAs($other)
        ->test(EditProduct::class, ['product' => $product])
        ->call('save')
        ->assertForbidden();
});
```

## Componentes anidados

Si un componente padre incluye un componente hijo (`<livewire:product-card :product="$product" />`), testea cada uno por separado — no es necesario montar el árbol completo para probar la lógica de un hijo específico, salvo que el comportamiento a probar sea justamente la interacción entre ambos (ej. un evento que el padre debe recibir).
