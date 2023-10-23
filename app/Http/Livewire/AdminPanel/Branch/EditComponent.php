<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditComponent extends ModalComponent
{
    use AuthorizesRequests;

    public Branch $branch;
    public $name;
    public $phone;
    public $email;
    public $contract_number;
    public $person_contact;
    public $sub_branch;
    public $check_sub_supplier = false;

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|numeric|digits_between:6,12',
        'email' => 'required|email',
        'contract_number' => 'required|string',
        'person_contact' => 'required|string',
        'sub_branch' => 'nullable',
    ];

    public function mount()
    {
        $this->name   = $this->branch->name;
        $this->phone  = $this->branch->phone;
        $this->email  = $this->branch->email;
        $this->contract_number = $this->branch->contract_number;
        $this->person_contact  = $this->branch->person_contact;
        $this->sub_branch = $this->branch->sub_branch;
        if($this->sub_branch) {
            $this->check_sub_supplier = true;
        }
    }

    public function update()
    {
        $this->authorize('update', $this->branch);

        $this->branch->update($this->validate());

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
        return view('livewire.admin-panel.branch.edit-component', [
            'branches' => Branch::all()->except($this->branch->id)
        ]);
    }
}
