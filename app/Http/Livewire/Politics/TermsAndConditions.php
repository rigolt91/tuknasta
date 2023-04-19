<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class TermsAndConditions extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.terms-and-conditions');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
