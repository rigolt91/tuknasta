# Patrones Eloquent

Esta guía cubre patrones de Eloquent más allá de lo básico (fillable, relaciones simples, casts) que ya se ven en `assets/ejemplo-recurso-completo.md`. Aplica igual sin importar si el proyecto usa API REST, Livewire, o Inertia — Eloquent es la capa de datos, independiente de la capa de vistas.

## Query Scopes

Encapsula condiciones de consulta reutilizables en vez de repetir el mismo `where()` en varios lugares del código.

**Scope local** (se invoca explícitamente):

```php
class Product extends Model
{
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    public function scopePriceBelow(Builder $query, float $amount): void
    {
        $query->where('price', '<', $amount);
    }
}

// Uso: se encadenan igual que cualquier método de query builder
Product::active()->priceBelow(100)->get();
```

**Scope global** (se aplica automáticamente a toda consulta del modelo — úsalo con cuidado, ya que es un comportamiento implícito):

```php
class Product extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('active', function (Builder $query) {
            $query->where('active', true);
        });
    }
}
```

Usa scope global solo cuando la condición debería aplicar prácticamente siempre (ej. multi-tenancy: filtrar por `tenant_id` en cada consulta) — para filtros ocasionales, un scope local es más predecible y explícito.

## Accessors y Mutators

Usa la sintaxis moderna con `Attribute::make()` (Laravel 9+), no los métodos antiguos `getXAttribute`/`setXAttribute` en proyectos nuevos.

```php
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => '$' . number_format($this->price, 2),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucfirst(trim($value)),
        );
    }
}
```

- Usa accessors para datos derivados que se calculan igual en todos lados (evita repetir el formato en cada Resource/Blade/componente).
- No abuses de mutators para lógica de negocio compleja — si la transformación involucra otras tablas o reglas de negocio no triviales, eso pertenece a un Service/Action, no al modelo.

## Observers

Para reaccionar a eventos del ciclo de vida del modelo (creating, updating, deleting, etc.) sin ensuciar el modelo ni el controlador con esa lógica:

```php
class ProductObserver
{
    public function creating(Product $product): void
    {
        $product->slug = Str::slug($product->name);
    }

    public function deleted(Product $product): void
    {
        Storage::delete($product->images->pluck('path')->toArray());
    }
}

// Registro (en un Service Provider)
Product::observe(ProductObserver::class);
```

Usa un Observer cuando el efecto debe ocurrir *siempre* que el modelo cambie de cierta forma, sin importar desde dónde se disparó (controlador, comando Artisan, seeder). Si el efecto solo debe ocurrir en un flujo específico (ej. solo al crear desde este endpoint particular), esa lógica va mejor en el Service/Action de ese flujo, no en un Observer global.

## Relaciones avanzadas

**Polimórficas** (un modelo pertenece a más de un tipo de padre, ej. comentarios en productos y en posts):

```php
class Comment extends Model
{
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}

class Product extends Model
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
```

**hasManyThrough** (relación indirecta a través de otro modelo, ej. pedidos de un vendedor a través de sus productos):

```php
class Seller extends Model
{
    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(OrderItem::class, Product::class);
    }
}
```

**Tabla pivote con datos adicionales** (muchos-a-muchos con atributos propios en la relación, ej. cantidad en un pedido):

```php
class Order extends Model
{
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }
}

// Uso
$order->products()->attach($productId, ['quantity' => 3, 'unit_price' => 49.90]);
```

## Optimización de consultas para datasets grandes

- **`select()` explícito** cuando no necesitas todas las columnas, especialmente en colecciones grandes o relaciones cargadas con `with()`:

```php
Product::select(['id', 'name', 'price'])->with('category:id,name')->get();
```

- **`chunk()`** para procesar muchos registros sin cargar todo en memoria (ej. un comando Artisan que recorre toda la tabla):

```php
Product::where('active', true)->chunk(200, function ($products) {
    foreach ($products as $product) {
        // procesar
    }
});
```

- **`lazy()`** como alternativa a `chunk()` cuando quieres iterar con una sintaxis más simple (usa cursores internamente):

```php
foreach (Product::lazy() as $product) {
    // procesar uno por uno, sin cargar todos en memoria
}
```

No uses `chunk()`/`lazy()` para colecciones pequeñas que ya cabrían en un `get()` normal — es una optimización para volumen real, no un default universal.

## Soft Deletes

```php
class Product extends Model
{
    use SoftDeletes;
}
```

- Al usar `SoftDeletes`, las consultas normales excluyen automáticamente los registros eliminados — usa `withTrashed()` u `onlyTrashed()` cuando necesites incluirlos explícitamente.
- Ten en cuenta el efecto en relaciones: si un `Product` tiene soft delete pero sus `OrderItem` no, un pedido antiguo seguirá referenciando un producto "eliminado" — decide conscientemente si eso es el comportamiento deseado o si la relación necesita `withTrashed()` para mostrarse correctamente en el historial.
- Una migración de soft delete agrega la columna `deleted_at` (`$table->softDeletes()`), y debe considerarse en el diseño de base de datos si el proyecto la usa desde el inicio (ver `diseno-base-datos` de la cadena de análisis).

## Mutación masiva segura

Más allá de definir `fillable` en el modelo (ver `laravel-arquitectura-avanzada` para el principio de seguridad), un par de patrones adicionales:

- Si necesitas asignar un campo que deliberadamente NO está en `fillable` (ej. `user_id` que siempre debe venir del usuario autenticado, nunca del input), asígnalo explícitamente por fuera del array validado, nunca lo agregues a `fillable` solo para poder mutarlo masivamente:

```php
Product::create([...$request->validated(), 'user_id' => $request->user()->id]);
```

- Evita `guarded = []` (desactivar toda protección de mutación masiva) salvo en un caso muy controlado y deliberado — es la forma más fácil de reintroducir el problema que `fillable` existe para prevenir.
