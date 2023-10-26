<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class WelcomeComponent extends Component
{
    public $recomendedProduct;

    public function mount(Product $product)
    {
        $this->recomendedProduct = $product->whereRecommend(true)->count();
    }

    public function render()
    {
        return view('welcome-component');
    }
}
