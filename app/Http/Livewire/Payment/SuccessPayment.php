<?php

namespace App\Http\Livewire\Payment;

use LivewireUI\Modal\ModalComponent;

class SuccessPayment extends ModalComponent
{
    public $message;

    public function mount($message = '')
    {
        $this->message = $message;
    }

    public function close()
    {
        return redirect()->route('dashboard');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.payment.success-payment');
    }
}
