<?php

namespace App\Http\Livewire\Payment;

use App\Http\Traits\CartTrait;
use Livewire\Component;

class Payment extends Component
{
    use CartTrait;

    protected $listeners = ['refreshPayment' => '$refresh'];

    public function mountPayment()
    {
        $this->cartsTrait();

        if($this->total_products == 0)
        {
            return redirect()->route('cart.details');
        }
    }

    public function paymentDelivery()
    {
        try {
            $this->validate(['contact' => 'required']);

            return redirect()->route('payment.delivery');
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
    }

    public function render()
    {
        $this->mountPayment();

        return view('livewire.payment.payment');
    }
}
