<?php

namespace App\Policies;

use App\Models\User;

class UserRolePolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('administrator');
    }

    public function update(User $user): bool
    {
        return $user->hasRole('administrator');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('administrator');
    }
}
