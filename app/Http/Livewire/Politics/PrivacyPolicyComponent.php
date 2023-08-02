<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class PrivacyPolicyComponent extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.privacy-policy-component');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
