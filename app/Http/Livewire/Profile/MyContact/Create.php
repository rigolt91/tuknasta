<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\UserContact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends ModalComponent
{
    public $user;
    public $name;
    public $last_name;
    public $email;
    public $dni;
    public $phone;
    public $street;
    public $between_streets;
    public $number;
    public $country;
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

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function store(UserContact $userContact)
    {
        $user = $this->user->userContact()->where('email', $this->email)->first();

        $user ? $user->update([ 'trash' => false ]) : $this->user->userContact()->create($this->validate());

        $this->closeModalWithEvents([MyContact::getName() => 'refreshMyContacts']);
    }

    public function render()
    {
        return view('livewire.profile.my-contact.create', [
            'provinces' => Province::select('id', 'name')->get(),
            'municipalities' => Municipality::select('id', 'name', 'province_id')->where('province_id', $this->province_id)->get(),
        ]);
    }
}
