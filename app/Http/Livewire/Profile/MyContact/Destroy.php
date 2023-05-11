<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use App\Models\UserContact;

class Destroy extends ModalComponent
{
    public $contact;

    public function mount(UserContact $contact)
    {
        $this->contact = $contact;
    }

    public function destroy()
    {
        try {
            $this->contact->delete();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.profile.my-contact.destroy');
    }
}
