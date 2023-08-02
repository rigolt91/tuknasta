<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\UserContact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MyContactComponent extends ModalComponent
{
    use AuthorizesRequests;

    public $user;
    public $contacts;

    protected $listeners = ['refreshMyContacts' => '$refresh'];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function create()
    {
        $this->emit('openModal', 'profile.my-contact.create-component');
    }

    public function edit($contact)
    {
        $this->emit('openModal', 'profile.my-contact.edit-component', ['contact' => $contact]);
    }

    public function delete($contact)
    {
        $this->emit('openModal', 'profile.my-contact.destroy-component', ['contact' => $contact]);
    }

    public function setPrefer(UserContact $contact)
    {
        $this->authorize('update', $contact);

        $this->user->userContact()->update(['prefer' => false]);

        $contact->update(['prefer' => !$contact->prefer]);

        $this->emit('refreshPayment');
        $this->emit('refreshDelivery');
        $this->emit('refreshConfirm');
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        $this->contacts = $this->user->userContact()->get();

        return view('livewire.profile.my-contact.my-contact-component');
    }
}
