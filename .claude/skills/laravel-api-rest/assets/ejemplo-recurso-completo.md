# Ejemplo de Recurso Completo — Producto (API REST)

Este ejemplo ilustra el orden y la forma esperada de cada pieza para un recurso simple. Úsalo como referencia de estilo, no lo copies literal si el proyecto ya tiene convenciones propias establecidas.

## 1. Migración

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

## 2. Modelo

```php
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'user_id'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

## 3. Policy

```php
class ProductPolicy
{
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}
```

## 4. Form Request

```php
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // creación abierta a cualquier usuario autenticado
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

## 5. API Resource

```php
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
```

## 6. Controlador

```php
class ProductController extends Controller
{
    public function store(StoreProductRequest $request): ProductResource
    {
        $product = Product::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        return new ProductResource($product);
    }
}
```

## 7. Rutas

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
});
```

## 8. Test (Pest)

```php
it('crea un producto correctamente', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/products', ['name' => 'Silla', 'price' => 49.90]);

    $response->assertStatus(201)
        ->assertJsonPath('data.name', 'Silla');

    $this->assertDatabaseHas('products', ['name' => 'Silla']);
});

it('impide actualizar un producto ajeno', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $product = Product::factory()->for($owner)->create();

    $response = $this->actingAs($other, 'sanctum')
        ->putJson("/api/products/{$product->id}", ['name' => 'Otro nombre']);

    $response->assertStatus(403);
});
```

Nota cómo cada pieza tiene una sola responsabilidad: la Request valida, la Policy autoriza, el Resource formatea, el controlador solo orquesta. Esto es lo que se espera replicar en cualquier recurso nuevo, ajustando la complejidad según el caso real.
