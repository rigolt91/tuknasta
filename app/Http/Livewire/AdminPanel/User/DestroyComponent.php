<?php

namespace App\Http\Livewire\AdminPanel\User;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use App\Repositories\UserRepository;

class DestroyComponent extends ModalComponent
{
    public User $user;

    public function destroy()
    {
        $this->user->delete();

        $this->closeModalWithEvents([ UserComponent::getName() => 'refreshUsers' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.user.destroy-component');
    }
}
