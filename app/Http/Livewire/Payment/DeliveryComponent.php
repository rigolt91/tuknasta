<?php

namespace App\Http\Livewire\Payment;

use App\Http\Traits\CartTrait;
use Livewire\Component;
use App\Models\DeliveryMethod;

class DeliveryComponent extends Component
{
    use CartTrait;

    public $delivery_method = 1;

    public $listeners = ['refreshDelivery' => '$refresh'];

    public function mountDelivery()
    {
        $this->cartsTrait();

        if ($this->total_products == 0) {
            return redirect()->route('cart.details');
        }
    }

    public function deliveryMethod($method)
    {
        $this->delivery_method = $method;
    }

    public function paymentConfirm()
    {
        return redirect()->route('payment.confirm', $this->delivery_method);
    }

    public function render()
    {
        $this->mountDelivery();

        return view('livewire.payment.delivery-component', [
            'delivery_methods' => DeliveryMethod::select('id', 'name')->get(),
        ]);
    }
}
