<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateComponent extends ModalComponent
{
    use AuthorizesRequests;

    public $name;
    public $phone;
    public $email;
    public $contract_number;
    public $person_contact;
    public $sub_branch;
    public $check_sub_supplier = false;

    protected $rules = [
        'name' => 'required|string|unique:branches,name',
        'phone' => 'required|numeric|digits_between:6,12|unique:branches,phone',
        'email' => 'required|email|unique:branches,email',
        'contract_number' => 'required|string',
        'person_contact' => 'required|string|unique:branches,person_contact',
        'sub_branch' => 'nullable',
    ];

    public function store(Branch $branch)
    {
        $this->authorize('create', $branch);

        $branch->create($this->validate());

        $this->emit('refreshBranches');

        $this->closeModalWithEvents([ BranchComponent::getName() => 'refreshBranches' ]);
    }

    public function setCheckSubSupplier() {
        $this->check_sub_supplier = !$this->check_sub_supplier;
        $this->sub_branch = null;
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.branch.create-component', [
            'branches' => Branch::all()
        ]);
    }
}
