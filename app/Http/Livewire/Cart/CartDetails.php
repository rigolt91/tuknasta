<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use App\Http\Traits\CartTrait;

class CartDetails extends Component
{
    use CartTrait;

    protected $listeners = ['refreshCartDetails' => '$refresh'];

    public function render()
    {
        $this->cartsTrait();

        return view('livewire.cart.cart-details');
    }
}
