# Ejemplo de Componente Completo — CRUD de Productos (Livewire)

## 1. Migración y modelo

(igual que en cualquier app Laravel — ver `laravel-api-rest` para el patrón de migración/modelo si hace falta repasar)

## 2. Policy

```php
class ProductPolicy
{
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}
```

## 3. Form Object

```php
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

    public function save(): void
    {
        $this->validate();

        if ($this->product) {
            $this->product->update($this->only(['name', 'price']));
        } else {
            Product::create([...$this->only(['name', 'price']), 'user_id' => auth()->id()]);
        }
    }
}
```

## 4. Componente

```php
class ProductManager extends Component
{
    public ProductForm $form;
    public bool $showForm = false;
    public ?Product $editing = null;

    #[Computed]
    public function products()
    {
        return Product::where('user_id', auth()->id())->latest()->get();
    }

    public function edit(Product $product): void
    {
        $this->authorize('update', $product);
        $this->editing = $product;
        $this->form->setProduct($product);
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->form->save();
        $this->dispatch('product-saved');
        $this->reset(['showForm', 'editing']);
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.product-manager');
    }
}
```

## 5. Vista

```html
<div>
    @if ($showForm)
        <form wire:submit="save">
            <input type="text" wire:model="form.name" placeholder="Nombre">
            @error('form.name') <span>{{ $message }}</span> @enderror

            <input type="number" wire:model="form.price" placeholder="Precio">
            @error('form.price') <span>{{ $message }}</span> @enderror

            <button type="submit">Guardar</button>
        </form>
    @else
        <button wire:click="$set('showForm', true)">Nuevo producto</button>
    @endif

    <ul>
        @foreach ($this->products as $product)
            <li wire:key="{{ $product->id }}">
                {{ $product->name }} — ${{ $product->price }}
                <button wire:click="edit({{ $product->id }})">Editar</button>
            </li>
        @endforeach
    </ul>
</div>
```

## 6. Tests

```php
it('crea un producto nuevo', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(ProductManager::class)
        ->set('showForm', true)
        ->set('form.name', 'Silla')
        ->set('form.price', 49.90)
        ->call('save')
        ->assertDispatched('product-saved');

    $this->assertDatabaseHas('products', ['name' => 'Silla', 'user_id' => $user->id]);
});

it('impide editar un producto ajeno', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $product = Product::factory()->for($owner)->create();

    Livewire::actingAs($other)
        ->test(ProductManager::class)
        ->call('edit', $product->id)
        ->assertForbidden();
});
```

Nota cómo `#[Computed]` evita guardar la lista completa de productos como propiedad pública (se recalcula en cada render sin viajar como estado serializado), y el Form Object se reutiliza tanto para crear como para editar.
