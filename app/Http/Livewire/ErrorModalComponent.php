<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class ErrorModalComponent extends ModalComponent
{
    public $message;

    public function mount($message)
    {
        $this->message = $message;
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.error-modal-component');
    }
}
