<?php

namespace App\Providers;

use App\Providers\AddProductCart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Product;

class RemoveProductAfterFewMinutes implements ShouldQueue
{
    public $delay = 1800;
    public $tries = 2;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AddProductCart $event): void
    {
        foreach($event->user->cart as $cart)
        {
            $this->restoreProductStock($cart->product_id, $cart->units);
            $cart->delete();
        }
    }

    public function restoreProductStock($product_id, $units)
    {
        $product = Product::find($product_id);
        $product->stock = $product->stock + $units;
        $product->save();
    }
}
