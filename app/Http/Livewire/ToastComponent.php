<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ToastComponent extends Component
{
    public function details($slug)
    {
        return redirect()->route('product.details', $slug);
    }

    public function render()
    {
        return view('livewire.toast-component', [
            'product' => Product::orderByRaw("RAND()")->select('name', 'image', 'slug')->whereRecommend(true)->limit(1)->first()
        ]);
    }
}
