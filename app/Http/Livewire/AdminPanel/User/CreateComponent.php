<?php

namespace App\Http\Livewire\AdminPanel\User;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use LivewireUI\Modal\ModalComponent;

class CreateComponent extends ModalComponent
{
    use PasswordValidationRules;

    public $name;
    public $last_name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role = 2;

    public function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => $this->passwordRules(),
        ]);

        $user = User::withTrashed()->where('email', $this->email)->first();

        if(! $user)
        {
            $user = User::create([
                'name' => $this->name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make($this->password),
            ]);

            $user->assignRole(Role::find($this->role)->name);
        } else {
            $user->restore();
        }

        $this->closeModalWithEvents([ UserComponent::getName() => 'refreshUsers' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.user.create-component', ['roles' => Role::get()]);
    }
}
