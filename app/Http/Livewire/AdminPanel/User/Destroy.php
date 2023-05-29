<?php

namespace App\Http\Livewire\AdminPanel\User;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Destroy extends ModalComponent
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function destroy()
    {
        try {
            $this->user->delete();

            $this->closeModalWithEvents([ Users::getName() => 'refreshUsers' ]);
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
        return view('livewire.admin-panel.user.destroy');
    }
}
