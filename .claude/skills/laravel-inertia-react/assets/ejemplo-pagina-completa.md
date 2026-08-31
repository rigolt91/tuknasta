# Ejemplo de Página Completa — Productos (Inertia + React)

## 1. Migración, modelo y Policy

(igual que en cualquier app Laravel — ver `laravel-api-rest` para el patrón base)

## 2. Form Request

```php
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
```

## 3. API Resource (reutilizado para dar forma a las props)

```php
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
```

## 4. Controlador

```php
class ProductController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection(
                Product::where('user_id', auth()->id())->get()
            ),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('products.index');
    }
}
```

## 5. Rutas

```php
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});
```

## 6. Tipo TypeScript

```ts
// resources/js/types/index.ts
export type Product = { id: number; name: string; price: number };
export type ProductsIndexProps = { products: Product[] };
```

## 7. Página React

```tsx
// resources/js/Pages/Products/Index.tsx
import { useForm } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import type { ProductsIndexProps } from '@/types';

function ProductsIndex({ products }: ProductsIndexProps) {
  const { data, setData, post, processing, errors, reset } = useForm({ name: '', price: 0 });

  function submit(e: React.FormEvent) {
    e.preventDefault();
    post('/products', { onSuccess: () => reset() });
  }

  return (
    <div>
      <form onSubmit={submit}>
        <input
          value={data.name}
          onChange={(e) => setData('name', e.target.value)}
          placeholder="Nombre"
        />
        {errors.name && <span role="alert">{errors.name}</span>}

        <input
          type="number"
          value={data.price}
          onChange={(e) => setData('price', Number(e.target.value))}
        />
        {errors.price && <span role="alert">{errors.price}</span>}

        <button type="submit" disabled={processing}>Guardar</button>
      </form>

      <ul>
        {products.map((p) => (
          <li key={p.id}>{p.name} — ${p.price}</li>
        ))}
      </ul>
    </div>
  );
}

ProductsIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;

export default ProductsIndex;
```

## 8. Tests

```php
// Backend
it('crea un producto y redirige al índice', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/products', ['name' => 'Silla', 'price' => 49.90])
        ->assertRedirect('/products');

    $this->assertDatabaseHas('products', ['name' => 'Silla', 'user_id' => $user->id]);
});

it('muestra errores de validación', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/products', ['price' => 100])
        ->assertSessionHasErrors('name');
});
```

```tsx
// Frontend
it('muestra la lista de productos', () => {
  render(<ProductsIndex products={[{ id: 1, name: 'Silla', price: 49.9 }]} />);
  expect(screen.getByText(/silla/i)).toBeInTheDocument();
});
```

Nota cómo el Form Request y el API Resource son exactamente el mismo patrón que en `laravel-api-rest` — lo único que cambia es que el controlador devuelve `Inertia::render()` en vez de una respuesta JSON directa, y el frontend es un componente de página en vez de un consumidor externo de la API.
