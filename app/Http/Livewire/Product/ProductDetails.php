<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product as MProduct;

class ProductDetails extends Component
{
    public $product_id;
    public $image;
    public $name;
    public $description;
    public $price;
    public $previous_price;
    public $subcategory_id;

    public function mount($slug)
    {
        $product = MProduct::where('slug', $slug)->first();

        $this->product_id = $product->id;
        $this->image = $product->image;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->previous_price = number_format($product->previous_price, 2);
        $this->subcategory_id = $product->subcategory_id;
    }

    public function render()
    {
        return view('livewire.product.product-details', [
            'products' => MProduct::select('id', 'name', 'short_description', 'price', 'slug', 'image')->where('id', $this->product_id)->where('show', true)->get(),
        ]);
    }
}
