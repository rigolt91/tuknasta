<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use App\Http\Traits\CartTrait;

class CartDetails extends Component
{
    use CartTrait;

    protected $listeners = ['refreshCartDetails' => '$refresh'];

    public function mountCartDetails()
    {
        $this->cartsTrait();
    }

    public function render()
    {
        $this->mountCartDetails();

        return view('livewire.cart.cart-details');
    }
}
