# Formularios y Validación — Livewire

## Form Object

Para formularios con varios campos o reutilizados entre crear/editar:

```php
// app/Livewire/Forms/ProductForm.php
class ProductForm extends Form
{
    public ?Product $product = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|numeric|min:0')]
    public float $price = 0;

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->price = $product->price;
    }

    public function store(): Product
    {
        $this->validate();
        return Product::create($this->only(['name', 'price']));
    }

    public function update(): void
    {
        $this->validate();
        $this->product->update($this->only(['name', 'price']));
    }
}
```

```php
// app/Livewire/Products/CreateProduct.php
class CreateProduct extends Component
{
    public ProductForm $form;

    public function save(): void
    {
        $this->form->store();
        $this->dispatch('product-created');
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.products.create-product');
    }
}
```

```html
<!-- resources/views/livewire/products/create-product.blade.php -->
<form wire:submit="save">
    <input type="text" wire:model="form.name">
    @error('form.name') <span>{{ $message }}</span> @enderror

    <input type="number" wire:model="form.price">
    @error('form.price') <span>{{ $message }}</span> @enderror

    <button type="submit">Guardar</button>
</form>
```

## Validación en tiempo real vs. al enviar

- `wire:model` (sin `.live`): sincroniza el valor solo cuando el componente hace un request de todas formas (ej. al enviar el formulario) — más eficiente, menos requests.
- `wire:model.live`: sincroniza en cada cambio de tecla — úsalo solo cuando necesitas reaccionar en tiempo real (ej. un contador de caracteres, una búsqueda con debounce), no como default en todo formulario.
- Para debounce en validación en tiempo real: `wire:model.live.debounce.500ms`.

## Manejo de archivos subidos

```php
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    #[Validate('image|max:2048')]
    public $photo;

    public function save(): void
    {
        $this->validate();
        $path = $this->photo->store('products', 'public');
        // ...
    }
}
```

- Los archivos se suben temporalmente antes de que el componente los procese — no asumas que `$this->photo` es la ruta final hasta después de `store()`.
- Valida tamaño y tipo siempre (`image|max:2048`), igual que harías con un Form Request en API REST.

## Errores de validación fuera del Form Object

Si el componente valida directo (sin Form Object, para casos simples):

```php
public string $email = '';

public function save(): void
{
    $this->validate(['email' => 'required|email']);
    // ...
}
```

Usa esto solo para formularios de 1-2 campos — para cualquier cosa más compleja, el Form Object mantiene el componente más legible y reutilizable.
