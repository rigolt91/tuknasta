<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch;

class Edit extends ModalComponent
{
    public $branch;
    public $name;
    public $phone;
    public $email;
    public $contract_number;
    public $person_contact;

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|numeric|digits_between:6,12',
        'email' => 'required|email',
        'contract_number' => 'required|string',
        'person_contact' => 'required|string',
    ];

    public function mount(Branch $branch)
    {
        $this->branch = $branch;
        $this->name   = $branch->name;
        $this->phone  = $branch->phone;
        $this->email  = $branch->email;
        $this->contract_number = $branch->contract_number;
        $this->person_contact  = $branch->person_contact;
    }

    public function update()
    {
        $validate = $this->validate();

        try {
            $this->branch->update($validate);

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
        return view('livewire.admin-panel.branch.edit');
    }
}
