<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class PreferProduct extends Component
{
    public function render()
    {
        return view('livewire.product.prefer-product', [
            'products' => Product::select('id', 'image', 'name', 'slug', 'short_description', 'price')
                            ->where('show', true)
                            ->where('recommend', true)
                            ->get(),
        ]);
    }
}
