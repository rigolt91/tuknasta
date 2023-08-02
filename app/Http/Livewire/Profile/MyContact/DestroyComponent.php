<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use App\Models\UserContact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DestroyComponent extends ModalComponent
{
    use AuthorizesRequests;

    public $contact;

    public function mount(UserContact $contact)
    {
        $this->contact = $contact;
    }

    public function destroy()
    {
        $this->authorize('delete', $this->contact);

        $this->contact->delete();

        $this->closeModalWithEvents([MyContactComponent::getName() => 'refreshMyContacts']);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.profile.my-contact.destroy-component');
    }
}
