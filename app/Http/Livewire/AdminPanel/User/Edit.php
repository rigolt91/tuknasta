<?php

namespace App\Http\Livewire\AdminPanel\User;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use PasswordValidationRules;

    public $user;
    public $name;
    public $last_name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role = $user->modelHasRole->role->id;
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => !empty($this->password) ? $this->passwordRules() : 'nullable',
        ]);

        $this->user->update([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ]);

        !empty($this->password) ? $this->user->update(['password' => Hash::make($this->password)]) : '';

        $this->user->removeRole($this->user->modelHasRole->role->name);

        $this->user->assignRole(Role::find($this->role)->name);

        $this->closeModalWithEvents([ Users::getName() => 'refreshUsers' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.user.edit', [
            'roles' => Role::select('id', 'name')->get(),
        ]);
    }
}
