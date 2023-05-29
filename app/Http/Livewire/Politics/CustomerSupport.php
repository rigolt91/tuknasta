<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class CustomerSupport extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.customer-support');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
