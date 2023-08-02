<?php

namespace App\Http\Livewire\AdminPanel\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function create()
    {
        $this->emit('openModal', 'admin-panel.user.create-component');
    }

    public function edit($user)
    {
        $this->emit('openModal', 'admin-panel.user.edit-component', ['user' => $user]);
    }

    public function delete($user)
    {
        $this->emit('openModal', 'admin-panel.user.destroy-component', ['user' => $user]);
    }

    public function disabled(User $user)
    {
        $user->update(['disabled' => !$user->disabled]);
    }

    public function render()
    {
        return view('livewire.admin-panel.user.user-component', ['users' => User::paginate(10), 'userId' => Auth::id()]);
    }
}
