<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait CartSummaryTrait
{
    public $user;
    public $carts;
    public $total_products = 0;
    public $total_amount = 0;

    public function mountCart()
    {
        if (Auth::user()) {
            $this->user = Auth::user();
            $this->carts = $this->user->cart;
            $this->total_products = $this->carts->sum('units');
            $this->total_amount = $this->user->cartAmount();
        }
    }
}
