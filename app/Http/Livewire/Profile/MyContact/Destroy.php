<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use App\Models\UserContact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Destroy extends ModalComponent
{
    use AuthorizesRequests;

    public $contact;

    public function mount(UserContact $contact)
    {
        $this->contact = $contact;
    }

    public function destroy()
    {
        try {
            $this->authorize('update', $this->contact);

            $this->contact->update([ 'trash' => true ]);

            $this->closeModalWithEvents([MyContact::getName() => 'refreshMyContacts']);
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['Operation failed']);
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
