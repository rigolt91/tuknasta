<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class PrivacyPolicy extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.privacy-policy');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
