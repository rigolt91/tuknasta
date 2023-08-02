<?php

namespace App\Http\Livewire\AdminPanel\Product;

use App\Models\Branch;
use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class EditComponent extends ModalComponent
{
    use WithFileUploads;

    public Product $product;
    public $image;
    public $name;
    public $sku;
    public $slug;
    public $short_description;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $subcategory_id;
    public $branch_id;

    protected $rules = [
        'image' => 'nullable', //1 MB Max
        'name' => 'required|string',
        'sku' => 'required|string',
        'slug' => 'nullable|string',
        'short_description' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|integer',
        'subcategory_id' => 'required|integer',
        'branch_id' => 'required|integer',
    ];

    public function mount()
    {
        $this->image = $this->product->image;
        $this->name = $this->product->name;
        $this->sku = $this->product->sku;
        $this->slug = $this->product->slug;
        $this->short_description = $this->product->short_description;
        $this->description = $this->product->description;
        $this->price = $this->product->price;
        $this->stock = $this->product->stock;
        $this->category_id = $this->product->category_id;
        $this->subcategory_id = $this->product->subcategory_id;
        $this->branch_id = $this->product->branch_id;
    }

    public function update()
    {
        $this->validate();

        $image = ($this->image !== $this->product->image)
            ? $this->image->storeAs("public/products/$this->sku", substr(sha1(rand(1,999)),0,-30).'.jpg')
            : $this->image;

        $this->product->update([
            'image' => $image,
            'name'  => $this->name,
            'sku'   => $this->sku,
            'slug'  => $this->slug ?: strtolower(str_replace(' ', '-', $this->name)),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'previous_price' => ($this->price != $this->product->price ? $this->product->price : 0),
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'branch_id' => $this->branch_id,
        ]);

        $this->closeModalWithEvents([ ProductComponent::getName() => 'refreshProducts' ]);
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('livewire.admin-panel.product.edit-component', [
            'categories' => Category::get(),
            'subcategories' => Subcategory::whereCategory($this->category_id)->get(),
            'branches' => Branch::get(),
        ]);
    }
}
