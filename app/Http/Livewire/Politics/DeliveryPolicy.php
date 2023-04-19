<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class DeliveryPolicy extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.delivery-policy');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
