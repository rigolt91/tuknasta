<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class ReturnPolicyComponent extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.return-policy-component');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
