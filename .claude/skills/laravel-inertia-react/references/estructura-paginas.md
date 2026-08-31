# Estructura de Páginas — Inertia + React

## Organización recomendada

```
resources/
  js/
    Pages/
      Products/
        Index.tsx
        Create.tsx
        Edit.tsx
      Dashboard.tsx
    Components/          # Componentes reutilizables de UI (no páginas)
      Button.tsx
      Card.tsx
    Layouts/
      AppLayout.tsx       # Layout persistente (sidebar, header)
    types/
      index.ts            # Tipos compartidos, incluidas las props de página
```

- `Pages/` refleja la misma jerarquía que usas para nombrar las vistas en `Inertia::render('Products/Index', ...)` — el string debe coincidir exactamente con la ruta del archivo (sin extensión).
- Componentes de UI genéricos (botones, cards, inputs) van en `Components/`, nunca mezclados dentro de `Pages/`.

## Layouts persistentes

Para evitar que un layout compartido (sidebar, header) se vuelva a montar en cada navegación:

```tsx
// resources/js/Layouts/AppLayout.tsx
export default function AppLayout({ children }: { children: React.ReactNode }) {
  return (
    <div>
      <Sidebar />
      <main>{children}</main>
    </div>
  );
}
```

```tsx
// resources/js/Pages/Products/Index.tsx
import AppLayout from '@/Layouts/AppLayout';

function ProductsIndex({ products }: Props) {
  return <ProductList products={products} />;
}

ProductsIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;

export default ProductsIndex;
```

Usar `Component.layout = ...` (patrón de "layout persistente" de Inertia) en vez de envolver manualmente cada página evita que el layout pierda su estado (ej. una animación del sidebar) al navegar entre páginas.

## Rutas

Las páginas Inertia usan `routes/web.php`, no `routes/api.php` — Inertia depende de que la sesión de Laravel esté disponible de forma normal (cookies, CSRF), no de tokens de API.

```php
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});
```
