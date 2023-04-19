<?php

namespace App\Http\Livewire\AdminPanel\Branch;

use LivewireUI\Modal\ModalComponent;
use App\Models\Branch;

class Destroy extends ModalComponent
{
    public $branch;

    public function mount(Branch $branch)
    {
        $this->branch = $branch;
    }

    public function destroy()
    {
        try {
            $this->branch->delete();

            $this->emit('refreshBranches');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
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
