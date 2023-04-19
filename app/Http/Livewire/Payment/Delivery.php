<?php

namespace App\Http\Livewire\Payment;

use App\Http\Traits\CartTrait;
use Livewire\Component;
use App\Models\DeliveryMethod;

class Delivery extends Component
{
    use CartTrait;

    public $delivery_method = 1;

    public $listeners = ['refreshDelivery' => '$refresh'];

    public function mountDelivery()
    {
        $this->cartsTrait();

        if($this->total_products == 0) return redirect()->route('cart.details');
    }

    public function deliveryMethod($method)
    {
        $this->delivery_method = $method;
    }

    public function paymentConfirm()
    {
        try {
            $this->validate(['contact' => 'required']);

            if($this->delivery_method == 2 && $this->contact->province_id <> 11)
            {
                $this->emit('openModal', 'error-modal', ['message' => 'The home delivery service is only available for the province of Las Tunas.']);
            } else {
                return redirect()->route('payment.confirm', $this->delivery_method);
            }
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
    }

    public function render()
    {
        $this->mountDelivery();

        return view('livewire.payment.delivery', [
            'delivery_methods' => DeliveryMethod::select('id', 'name')->get(),
        ]);
    }
}
