<?php

namespace App\Http\Livewire\Product;

use App\Http\Traits\ProductStartTrait;
use Livewire\Component;
use App\Models\Product as MProduct;

class ProductDetails extends Component
{
    use ProductStartTrait;

    public $product;
    public $image;
    public $name;
    public $description;
    public $price;
    public $starts;
    public $previous_price;
    public $subcategory_id;

    public function mount($slug)
    {
        $product = MProduct::where('slug', $slug)->first();

        $this->product = $product;
        $this->image = $product->image;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->previous_price = number_format($product->previous_price, 2);
        $this->subcategory_id = $product->subcategory_id;
    }

    public function addProductCart()
    {
        $this->emit('addProductCart', $this->product->id);
    }

    public function render()
    {
        $this->starts = $this->getStarts();

        return view('livewire.product.product-details', [
            'products' => MProduct::select('id', 'name', 'short_description', 'price', 'slug', 'image')->where('id', $this->product->id)->where('show', true)->get(),
        ]);
    }
}
