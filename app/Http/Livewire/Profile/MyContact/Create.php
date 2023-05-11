<?php

namespace App\Http\Livewire\Profile\MyContact;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use App\Models\Municipality;

class Create extends ModalComponent
{
    public $contact;
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

    public function store()
    {
        $validate = $this->validate();

        try {
            Auth::user()->userContact()->create($validate);

            $this->emit('refreshMyContacts');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render()
    {
        return view('livewire.profile.my-contact.create', [
            'provinces' => Province::select('id', 'name')->get(),
            'municipalities' => Municipality::select('id', 'name', 'province_id')->where('province_id', 'LIKE', '%'.$this->province_id.'%')->get(),
        ]);
    }
}
