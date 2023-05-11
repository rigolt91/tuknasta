<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch;

class Create extends ModalComponent
{
    public $name;
    public $phone;
    public $email;
    public $contract_number;
    public $person_contact;

    protected $rules = [
        'name' => 'required|string|unique:branches,name',
        'phone' => 'required|numeric|digits_between:6,12|unique:branches,phone',
        'email' => 'required|email|unique:branches,email',
        'contract_number' => 'required|string',
        'person_contact' => 'required|string|unique:branches,person_contact',
    ];

    public function store()
    {
        $validate = $this->validate();

        try {
            Branch::create($validate);

            $this->emit('refreshBranches');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.branch.create');
    }
}
