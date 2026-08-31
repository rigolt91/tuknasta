---
name: laravel-livewire
description: >
  Implementa aplicaciones full-stack en Laravel usando Livewire: componentes con estado en el servidor, Blade como capa de vistas, validación con Livewire Form Objects, y actualización reactiva de UI sin escribir JavaScript ni una API REST separada. Usa esta skill SIEMPRE que el usuario pida crear o modificar un componente Livewire, una página con interactividad reactiva servida por Blade, o mencione explícitamente Livewire/wire:model/Volt. No uses esta skill junto con `laravel-api-rest` en el mismo recurso — son dos paradigmas distintos (con o sin API separada); si el proyecto usa Livewire, esa pantalla no necesita Form Request + API Resource + Controller REST.
---

# Laravel + Livewire

Esta skill cubre el desarrollo full-stack con Livewire: la aplicación entera vive dentro de Laravel, sin una API REST separada ni un frontend JavaScript independiente. La interactividad se logra con componentes que mantienen estado en el servidor y se re-renderizan vía requests AJAX que Livewire maneja automáticamente.

Es un paradigma distinto al de `laravel-api-rest` — no se combinan en el mismo recurso. Si el proyecto expone además una API pública para consumidores externos (app móvil, terceros), esa parte sí usa `laravel-api-rest`, pero las pantallas propias de la app web usan Livewire directamente.

## Principios que debe seguir siempre

1. **El componente Livewire es la unidad de trabajo**, no el controlador. Un componente tiene su propio estado (propiedades públicas), su lógica (métodos públicos invocables desde la vista), y su vista Blade asociada.
2. **Las propiedades públicas son el estado sincronizado con el navegador** — cualquier dato que la vista necesite mostrar o vincular con `wire:model` debe ser una propiedad pública. No uses variables locales dentro de `render()` para datos que el usuario debe poder modificar.
3. **Validación con Livewire Form Objects** (clases `Form` dedicadas) para formularios no triviales, en vez de reglas de validación dispersas como propiedades del componente. Para formularios simples de 1-2 campos, las reglas pueden ir directo en el componente si el Form Object sería sobre-ingeniería.
4. **Minimiza el estado que viaja al navegador.** Livewire serializa las propiedades públicas en cada request — no guardes ahí colecciones grandes completas si solo necesitas mostrar un subconjunto; usa computed properties (`#[Computed]`) para derivar datos sin guardarlos como estado.
5. **Eventos de Livewire para comunicación entre componentes**, no acoplar un componente hijo directamente a la lógica interna de otro. Usa `$this->dispatch('evento')` y `#[On('evento')]` para desacoplar.
6. **Autorización con Policies**, igual que en cualquier app Laravel — no la salgas del componente a mano; usa `$this->authorize()` dentro del método correspondiente.

## Flujo de trabajo

### 1. Entender qué se está construyendo

Si hay documentos previos de la cadena (requisitos, base de datos, diseño UX/UI), léelos para confirmar entidades, campos y pantallas esperadas. El diseño UX/UI es especialmente relevante aquí porque cada pantalla probablemente mapea a uno o varios componentes Livewire.

### 2. Decidir el alcance del componente

Un componente Livewire no debería intentar cubrir una página entera si esta tiene secciones independientes entre sí (ej. una tabla con filtros + un formulario de creación aparte) — divide en componentes más chicos que se comunican por eventos, en vez de un componente gigante con demasiadas responsabilidades.

### 3. Implementar en el orden correcto

Para una funcionalidad nueva:
1. Migración y modelo (igual que en cualquier app Laravel)
2. Policy si el recurso requiere autorización
3. Form Object (si el formulario lo amerita)
4. Componente Livewire (clase PHP: propiedades, métodos, `render()`)
5. Vista Blade asociada
6. Tests

### 4. Escribir tests junto con el código

Usa el helper de testing de Livewire (`Livewire::test()`), que permite probar el componente sin un navegador real:

```php
it('crea un producto desde el componente', function () {
    Livewire::test(CreateProduct::class)
        ->set('name', 'Silla')
        ->set('price', 49.90)
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('product-created');

    $this->assertDatabaseHas('products', ['name' => 'Silla']);
});

it('valida que el nombre sea requerido', function () {
    Livewire::test(CreateProduct::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});
```

Consulta `references/convenciones-tests-livewire.md` para más casos (eventos, computed properties, componentes anidados).

### 5. Verificar antes de dar por terminado

- Corre los tests del proyecto.
- Revisa que no haya estado innecesario en propiedades públicas (datos que deberían ser computed properties o que no necesitan viajar al navegador).
- Confirma que las acciones sensibles (editar/eliminar) llamen `$this->authorize()` antes de ejecutarse, no solo oculten el botón en la vista.

## Referencias

- `references/estructura-componentes.md` — organización de componentes, cuándo usar Volt (sintaxis de archivo único) vs. clase + vista separadas.
- `references/formularios-validacion.md` — Form Objects, reglas de validación en tiempo real (`wire:model.live`), manejo de archivos subidos.
- `references/convenciones-tests-livewire.md` — estructura de tests para componentes, eventos y computed properties.
- `assets/ejemplo-componente-completo.md` — ejemplo de referencia de un componente CRUD completo con Form Object, eventos y tests.
