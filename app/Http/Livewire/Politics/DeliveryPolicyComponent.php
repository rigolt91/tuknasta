<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class DeliveryPolicyComponent extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.delivery-policy-component');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
