<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\UserContact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends ModalComponent
{
    use AuthorizesRequests;

    public $contact;
    public $name;
    public $last_name;
    public $email;
    public $dni;
    public $phone;
    public $street;
    public $between_streets;
    public $number;
    public $province_id = '';
    public $municipality_id = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'dni' => 'required|string|digits:11',
        'email' => 'required|email',
        'phone' => 'required|numeric|digits_between:8,14',
        'street' => 'required|string|max:255',
        'between_streets' => 'required|string|max:255',
        'number' => 'required|string|max:20',
        'province_id' => 'required|integer',
        'municipality_id' => 'required|integer',
    ];

    public function mount(UserContact $contact)
    {
        $this->contact = $contact;
        $this->name = $contact->name;
        $this->last_name = $contact->last_name;
        $this->email = $contact->email;
        $this->dni = $contact->dni;
        $this->phone = $contact->phone;
        $this->street = $contact->street;
        $this->between_streets = $contact->between_streets;
        $this->number = $contact->number;
        $this->province_id = $contact->province_id;
        $this->municipality_id = $contact->municipality_id;
    }

    public function update()
    {
        $this->authorize('update', $this->contact);

        $this->contact->update($this->validate());

        $this->closeModalWithEvents([MyContact::getName() => 'refreshMyContacts']);
    }

    public function render()
    {
        return view('livewire.profile.my-contact.edit', [
            'provinces' => Province::select('id', 'name')->get(),
            'municipalities' => Municipality::select('id', 'name', 'province_id')->where('province_id', $this->province_id)->get(),
        ]);
    }
}
