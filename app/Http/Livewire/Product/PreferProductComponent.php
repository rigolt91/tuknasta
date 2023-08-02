<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class PreferProductComponent extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::recommend(true)->get();
    }

    public function render()
    {
        return view('livewire.product.prefer-product-component');
    }
}
