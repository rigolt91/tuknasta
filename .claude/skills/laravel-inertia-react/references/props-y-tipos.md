# Props y Tipos — Inertia + React

## Tipar las props de cada página

```ts
// resources/js/types/index.ts
export type Product = {
  id: number;
  name: string;
  price: number;
};

export type ProductsIndexProps = {
  products: Product[];
};
```

```tsx
// resources/js/Pages/Products/Index.tsx
import type { ProductsIndexProps } from '@/types';

export default function ProductsIndex({ products }: ProductsIndexProps) {
  return (
    <ul>
      {products.map((p) => (
        <li key={p.id}>{p.name} — ${p.price}</li>
      ))}
    </ul>
  );
}
```

## Mantener el tipo sincronizado con el API Resource del backend

El controlador envía como props exactamente lo que el `ProductResource` devuelve:

```php
public function index()
{
    return Inertia::render('Products/Index', [
        'products' => ProductResource::collection(Product::all()),
    ]);
}
```

Cuando cambies los campos de un `ProductResource`, actualiza el tipo TypeScript correspondiente en el mismo cambio — no dejes que se desincronicen. Si el proyecto crece mucho, considera generar los tipos automáticamente desde PHP (paquetes como `spatie/laravel-typescript-transformer` existen para esto), pero para proyectos chicos/medianos mantenerlos a mano y disciplinadamente sincronizados es suficiente.

## Props parciales y `only`/`except` en visitas

Para evitar recargar todas las props en cada navegación (ej. al aplicar un filtro que solo cambia la lista, no datos del layout):

```tsx
import { router } from '@inertiajs/react';

router.get('/products', { search: 'silla' }, { only: ['products'] });
```

- `only` le dice a Inertia que solo pida (y el controlador solo recalcule) las props indicadas — útil cuando alguna prop es costosa de calcular y no cambia con esa interacción.
- En el controlador, envuelve las props costosas en un closure para que Inertia las evalúe solo si realmente se piden:

```php
return Inertia::render('Products/Index', [
    'products' => fn () => ProductResource::collection(Product::filter($request)->get()),
    'filters' => $request->only(['search']),
]);
```

## Compartir datos globales (usuario autenticado, flash messages)

Usa el middleware `HandleInertiaRequests` para compartir props disponibles en todas las páginas (ej. el usuario autenticado), en vez de repetirlas en cada controlador:

```php
// app/Http/Middleware/HandleInertiaRequests.php
public function share(Request $request): array
{
    return [
        ...parent::share($request),
        'auth' => [
            'user' => $request->user(),
        ],
        'flash' => [
            'success' => fn () => $request->session()->get('success'),
        ],
    ];
}
```
