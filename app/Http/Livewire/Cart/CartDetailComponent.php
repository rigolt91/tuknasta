<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use App\Http\Traits\CartTrait;

class CartDetailComponent extends Component
{
    use CartTrait;

    protected $listeners = ['refreshCartDetails' => '$refresh'];

    public function payment()
    {
        return redirect()->route('payment.payment');
    }

    public function render()
    {
        $this->cartsTrait();

        return view('livewire.cart.cart-detail-component');
    }
}
