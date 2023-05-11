<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\UserContact;

class MyContact extends ModalComponent
{
    public $contacts;

    protected $listeners = ['refreshMyContacts' => '$refresh'];

    public function mountMyContact()
    {
        $this->contacts = Auth::user()->userContact()->get();
    }

    public function setFavorite(UserContact $contact)
    {
        $this->userFavoriteFalse();

        $contact->prefer = !$contact->prefer;
        $contact->save();

        $this->emit('refreshPayment');
        $this->emit('refreshDelivery');
        $this->emit('refreshConfirm');
    }

    public function userFavoriteFalse()
    {
        foreach($this->contacts as $contact)
        {
            $contact->prefer = false;
            $contact->save();
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render()
    {
        $this->mountMyContact();

        return view('livewire.profile.my-contact.my-contact');
    }
}
