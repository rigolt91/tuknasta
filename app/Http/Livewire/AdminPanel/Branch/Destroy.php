<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch as MBranch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Destroy extends ModalComponent
{
    use AuthorizesRequests;

    public $branch;

    public function mount(MBranch $branch)
    {
        $this->branch = $branch;
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', $this->branch);

            $this->branch->delete();

            $this->closeModalWithEvents([ Branch::getName() => 'refreshBranches' ]);
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['Operation failed.']);
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.branch.destroy');
    }
}
