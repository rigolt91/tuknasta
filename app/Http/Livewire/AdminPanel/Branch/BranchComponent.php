<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use Livewire\Component;
use App\Models\Branch;
use Livewire\WithPagination;

class BranchComponent extends Component
{
    use WithPagination;

    protected $listeners = ['refreshBranches' => '$refresh'];

    public function create()
    {
        $this->emit('openModal', 'admin-panel.branch.create-component');
    }

    public function edit($branch)
    {
        $this->emit('openModal', 'admin-panel.branch.edit-component', ['branch' => $branch]);
    }

    public function delete($branch)
    {
        $this->emit('openModal', 'admin-panel.branch.destroy-component', ['branch' => $branch]);
    }

    public function render()
    {
        return view('livewire.admin-panel.branch.branch-component', ['branches' => Branch::paginate(10)]);
    }
}
