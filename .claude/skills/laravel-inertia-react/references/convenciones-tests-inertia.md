# Convenciones de Tests — Inertia + React

## Backend (Pest/PHPUnit + assertInertia)

Usa el paquete oficial de testing de Inertia para Laravel (`inertiajs/inertia-laravel` ya incluye el helper `assertInertia`).

```php
use Inertia\Testing\AssertableInertia as Assert;

it('muestra la página de productos con los datos correctos', function () {
    $user = User::factory()->create();
    Product::factory()->for($user)->count(2)->create();

    $this->actingAs($user)
        ->get('/products')
        ->assertInertia(fn (Assert $page) => $page
            ->component('Products/Index')
            ->has('products', 2)
            ->where('products.0.name', fn ($name) => is_string($name))
        );
});

it('redirige si el usuario no está autenticado', function () {
    $this->get('/products')->assertRedirect('/login');
});

it('valida el formulario de creación', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/products', ['price' => 100]) // falta 'name'
        ->assertSessionHasErrors('name');
});
```

- `assertInertia` verifica el componente renderizado y la forma de las props, sin necesidad de parsear HTML.
- Los errores de validación de Inertia se verifican con `assertSessionHasErrors`, igual que en un formulario Blade tradicional (Inertia los propaga vía sesión/redirect, no vía JSON directo como en API REST).

## Frontend (Vitest + React Testing Library)

Testea los componentes de página como cualquier componente React, pasando props mockeadas manualmente (sin necesidad de un servidor Inertia real):

```tsx
import { render, screen } from '@testing-library/react';
import ProductsIndex from '@/Pages/Products/Index';

it('renderiza la lista de productos', () => {
  render(<ProductsIndex products={[{ id: 1, name: 'Silla', price: 49.9 }]} />);
  expect(screen.getByText(/silla/i)).toBeInTheDocument();
});
```

Para componentes que usan `useForm` o `<Link>` de Inertia, envuelve el test con el contexto de Inertia si el componente lo requiere en runtime, o extrae la lógica de presentación a un componente hijo puro que no dependa directamente del hook para simplificar el test.

## Qué NO testear

- No dupliques en el frontend la validación que ya se prueba en el backend (Form Request) — el test de frontend debe enfocarse en que la UI muestre el error correctamente cuando `errors` llega poblado, no en repetir las reglas de negocio.
