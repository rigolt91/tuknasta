<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;
use App\Providers\AddProductCart;

class CartComponent extends Component
{
    public $user;
    public $product;
    public $units;
    public $carts;
    public $total_products = 0;
    public $total_amount = 0;

    protected $listeners = [
        'refreshCart' => '$refresh',
        'addProductCart' => 'addProductCart',
        'clearCart' => 'clearCart',
        'clearCartAll' => 'clearCartAll',
        'removeProductCart' => 'removeProductCart',
        'deleteUserJob' => 'deleteUserJob',
        'restoreProductStock' => 'restoreProductStock',
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

    public function addProductCart(Product $product, $units = 1)
    {
        try {
            if ($this->user) {
                $stock = $product->stock - $units;
                if ($stock >= 0) {
                    $this->reduceProductStock($product, $stock);

                    $product_cart = Cart::where('user_id', $this->user->id)->where('product_id', $product->id)->first();
                    if(is_null($product_cart)) {
                        $this->createCart($product, $units);
                    } else {
                        $this->updateCart($product_cart, $units);
                    }
                    $this->refresh();
                } else {
                    $this->emit('openModal', 'error-modal-component', ['message' => 'Sorry, the requested product is currently out of stock.']);
                }
            } else {
                $this->emit('openModal', 'error-modal-component', ['message' => 'You must first authenticate yourself to be able to add products to the cart.']);
            }
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal-component', ['message' => $th->getMessage()]);
        }
    }

    public function createCart($product, $units)
    {
        $this->user->cart()->create(['product_id' => $product->id, 'units' => $units, 'price' => $product->price]);

        AddProductCart::dispatch($this->user);

        $this->saveUserJob();
    }

    public function updateCart($product, $units)
    {
        $product->update(['units' => $product->units + $units]);
    }

    public function reduceProductStock(Product $product, $stock)
    {
        $product->update(['stock' => $stock]);
    }

    public function restoreProductStock($cart)
    {
        $cart->product()->update(['stock' => $cart->product->stock + $cart->units]);
    }

    public function clearCart(Cart $cart)
    {
        $this->restoreProductStock($cart);

        $cart->delete();

        $this->refresh();
    }

    public function clearCartAll()
    {
        foreach ($this->user->cart as $cart) {
            $this->restoreProductStock($cart);
        }

        $this->user->cart()->delete();

        $this->deleteUserJob();

        $this->refresh();
    }

    public function removeProductCart(Cart $cart)
    {
        $cart->update(['units' => $cart->units - 1]);

        $cart->product()->update(['stock' => $cart->product->stock + 1]);

        if($cart->units == 0) {
            $cart->delete();
        }

        $this->refresh();
    }

    public function saveUserJob()
    {
        $job_id = DB::table('jobs')->whereQueue('default')->get()->last();
        if($job_id) {
            $this->user->userJob()->create(['job_id' => $job_id->id]);
        }
    }

    public function deleteUserJob()
    {
        foreach ($this->user->userJob as $job) {
            DB::table('jobs')->where('id', $job->job_id)->delete();

            $job->delete();
        }
    }

    public function refresh()
    {
        $this->emit('refreshCartSm');
        $this->emit('refreshCartDetails');
        $this->emit('refreshPayment');
        $this->emit('refreshDelivery');
        $this->emit('refreshConfirm');
    }

    public function render()
    {
        $this->mountCart();

        return view('livewire.cart.cart-component');
    }
}
