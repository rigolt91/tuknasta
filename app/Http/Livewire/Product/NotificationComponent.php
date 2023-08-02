<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class NotificationComponent extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::recommend()->orderByRaw('RAND()')->limit(1)->first();
    }

    public function render()
    {
        return view('livewire.product.notification-component');
    }
}
