<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DestroyComponent extends ModalComponent
{
    use AuthorizesRequests;

    public Branch $branch;

    public function destroy()
    {
        $this->authorize('delete', $this->branch);

        $this->branch->delete();

        $this->closeModalWithEvents([ BranchComponent::getName() => 'refreshBranches' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.branch.destroy-component');
    }
}
