<?php

namespace App\Http\Livewire\AdminPanel\Product;

use App\Models\Branch;
use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product as MProduct;

class Edit extends ModalComponent
{
    use WithFileUploads;

    public $product;
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

    public function mount(MProduct $product)
    {
        $this->product = $product;
        $this->image = $product->image;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
        $this->subcategory_id = $product->subcategory_id;
        $this->branch_id = $product->branch_id;
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

        $this->closeModalWithEvents([ Product::getName() => 'refreshProducts' ]);
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('livewire.admin-panel.product.edit', [
            'categories' => Category::select('id', 'name')->get(),
            'subcategories' => Subcategory::select('id', 'name')->where('category_id', 'LIKE', '%'.$this->category_id.'%')->get(),
            'branches' => Branch::select('id', 'name')->get(),
        ]);
    }
}
