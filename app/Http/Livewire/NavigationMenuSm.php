<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;
use App\Providers\AddProductCart;

class NavigationMenuSm extends Component
{
    public $user;
    public $product;
    public $units;
    public $carts;
    public $total_products = 0;
    public $total_amount = 0;

    protected $listeners = [
        'refreshCartSm' => '$refresh',
    ];

    public function mountCart()
    {
        if (Auth::user()) {
            $this->user = Auth::user();
            $this->carts = $this->user->cart;
            $this->total_products = $this->carts->sum('units');
            $this->total_amount = $this->user->cartAmount();
        }
    }

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
