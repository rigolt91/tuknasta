<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class Notification extends Component
{
    public function render()
    {
        return view('livewire.product.notification', [
            'product' => Product::select('id', 'image', 'name', 'slug', 'short_description', 'price')
                            ->where('show', true)
                            ->where('recommend', true)
                            ->orderByRaw('RAND()')
                            ->limit(1)
                            ->first(),
        ]);
    }
}
