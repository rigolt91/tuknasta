<?php

namespace App\Http\Livewire\Politics;

use LivewireUI\Modal\ModalComponent;

class ReturnPolicy extends ModalComponent
{
    public function render()
    {
        return view('livewire.politics.return-policy');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}
