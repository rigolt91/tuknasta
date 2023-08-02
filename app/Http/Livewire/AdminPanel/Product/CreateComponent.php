<?php

namespace App\Http\Livewire\AdminPanel\Product;

use App\Models\Branch;
use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class CreateComponent extends ModalComponent
{
    use WithFileUploads;

    public $image;
    public $name;
    public $sku;
    public $slug;
    public $short_description;
    public $description;
    public $price;
    public $stock;
    public $category_id = '';
    public $subcategory_id = '';
    public $branch_id = '';

    protected $rules = [
        'image' => 'required|image|max:1024',
        'name' => 'required|string|unique:products,name',
        'sku' => 'required|string|unique:products,sku',
        'slug' => 'nullable|string|unique:products,slug',
        'short_description' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|integer',
        'subcategory_id' => 'required|integer',
        'branch_id' => 'required|integer',
    ];

    public function store()
    {
        $this->validate();

        $image = $this->image->storeAs("public/products/$this->sku", substr(sha1(rand(1,999)),0,-30).'.jpg');

        Product::create([
            'image' => $image,
            'name'  => $this->name,
            'sku'   => $this->sku,
            'slug'  => $this->slug ?: strtolower(str_replace(' ', '-', $this->name)),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
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
        return view('livewire.admin-panel.product.create-component', [
            'categories' => Category::get(),
            'subcategories' => Subcategory::whereCategory($this->category_id)->get(),
            'branches' => Branch::get(),
        ]);
    }
}
