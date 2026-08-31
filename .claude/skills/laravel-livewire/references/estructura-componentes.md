# Estructura de Componentes — Livewire

## Organización recomendada

```
app/
  Livewire/
    Products/
      Index.php          # Listado + filtros
      CreateProduct.php  # Formulario de creación (modal o página aparte)
      EditProduct.php
    Forms/
      ProductForm.php    # Form Object reutilizado por Create/Edit
resources/
  views/
    livewire/
      products/
        index.blade.php
        create-product.blade.php
        edit-product.blade.php
```

- Agrupa componentes por dominio/recurso (`Products/`), igual que controladores en un proyecto API REST.
- Un Form Object compartido entre `CreateProduct` y `EditProduct` evita duplicar reglas de validación.

## Clase de componente vs. Volt (sintaxis de archivo único)

- **Clase + vista separadas** (patrón estándar arriba): recomendado para componentes con lógica sustancial, múltiples métodos, o que se reutilizan/testean de forma más tradicional.
- **Volt** (`resources/views/livewire/products/quick-toggle.blade.php` con PHP y Blade en el mismo archivo): útil para componentes pequeños y muy acotados (ej. un toggle simple) donde separar clase y vista sería más ceremonia que beneficio.

Si el proyecto ya eligió uno de los dos estilos de forma consistente, sigue ese estilo — no mezcles ambos sin razón.

## Comunicación entre componentes

```php
// Componente hijo (formulario)
$this->dispatch('product-created', productId: $product->id);

// Componente padre (listado), escuchando
#[On('product-created')]
public function refreshList(): void
{
    // recargar datos o simplemente dejar que Livewire re-renderice
}
```

- Prefiere eventos sobre pasar callbacks o acoplar componentes directamente.
- Si el evento debe llegar a un componente específico (no un broadcast general), usa `dispatch()->to(ComponenteEspecifico::class)`.

## Computed Properties

```php
use Livewire\Attributes\Computed;

#[Computed]
public function totalProducts(): int
{
    return Product::where('user_id', auth()->id())->count();
}
```

- Úsalas para datos derivados que no necesitan viajar como estado serializado — se recalculan en cada render pero no se envían al navegador como propiedad pública.
- No las uses para consultas muy costosas que se acceden múltiples veces en el mismo render sin necesidad — Livewire las cachea dentro del mismo ciclo de render, pero igual conviene ser consciente del costo si el dato es pesado.
