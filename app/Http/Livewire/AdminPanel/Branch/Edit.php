<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch as MBranch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends ModalComponent
{
    use AuthorizesRequests;

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

    public function mount(MBranch $branch)
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
        $this->authorize('update', $this->branch);

        $this->branch->update($this->validate());

        $this->closeModalWithEvents([ Branch::getName() => 'refreshBranches' ]);
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
