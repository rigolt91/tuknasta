<?php

namespace App\Http\Livewire\AdminPanel\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search;

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function setShow(User $user)
    {
        $user->update(['block' => !$user->show]);
    }

    public function render()
    {
        return view('livewire.admin-panel.user.users', [
            'users' => User::when($this->search, function($query) {
                            $query->where('name', 'like', '%'.$this->search.'%')->where('trash', false);
                        })
                        ->where('trash', false)
                        ->paginate(10),
            'admin_id' => User::select('id')->where('name', 'Administrator')->first()->id,
        ]);
    }
}
