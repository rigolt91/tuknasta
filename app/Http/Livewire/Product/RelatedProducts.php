<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class RelatedProducts extends Component
{
    public $product_id;
    public $products;

    public function mount(Product $product)
    {
        $this->product_id = $product->id;

        $this->products = Product::where('subcategory_id', $product->subcategory_id)->get()->except([$this->product_id]);
    }

    public function render()
    {
        return view('livewire.product.related-products');
    }
}
