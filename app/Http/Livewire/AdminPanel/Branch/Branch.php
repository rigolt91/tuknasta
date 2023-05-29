<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use Livewire\Component;
use App\Models\Branch as MBranch;
use Livewire\WithPagination;

class Branch extends Component
{
    use WithPagination;

    protected $listeners = ['refreshBranches' => '$refresh'];

    public function render()
    {
        return view('livewire.admin-panel.branch.branch', [
            'branches' => MBranch::select('id', 'name', 'phone', 'email', 'contract_number', 'person_contact')->paginate(10),
        ]);
    }
}
