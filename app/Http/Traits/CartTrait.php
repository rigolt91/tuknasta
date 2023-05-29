<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait CartTrait {
    public $user;
    public $email;
    public $contact;

    public $carts;
    public $total_amount;
    public $total_products;
    public $products;

    public function cartsTrait()
    {
        $this->user();
        $this->userCart();
        $this->totalAmount();
        $this->totalProducts();
    }

    public function user()
    {
        $this->user = Auth::user();
        $this->email = $this->user->email;
        $this->contact = $this->user->userContact()->where('prefer', true)->first();
    }

    public function userCart()
    {
       $this->carts = $this->user->cart;
    }

    public function totalAmount()
    {
        $this->total_amount = 0;

        foreach ($this->carts as $cart)
        {
            $this->total_amount += $cart->price * $cart->units;
        }
    }

    public function totalProducts()
    {
        $this->total_products = $this->user->cart->count();
    }
}
