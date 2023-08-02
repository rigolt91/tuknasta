<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class CustomerSupportComponent extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.customer-support-component');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
