<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\UserContact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MyContact extends ModalComponent
{
    use AuthorizesRequests;

    public $user;
    public $contacts;

    protected $listeners = ['refreshMyContacts' => '$refresh'];

    public function mount()
    {
        $this->user = Auth::user();
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
        $this->contacts = $this->user->userContact()->where('trash', false)->get();

        return view('livewire.profile.my-contact.my-contact');
    }
}
