<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class TermsAndConditionComponent extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.terms-and-condition-component');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
