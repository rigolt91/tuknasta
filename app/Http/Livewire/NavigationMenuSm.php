<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Traits\CartSummaryTrait;

class NavigationMenuSm extends Component
{
    use CartSummaryTrait;

    protected $listeners = [
        'refreshCartSm' => '$refresh',
    ];

    public function clearCart($cart)
    {
        $this->emit('clearCart', ['cart' => $cart]);
    }

    public function render()
    {
        $this->mountCart();
        return view('livewire.navigation-menu-sm');
    }
}
