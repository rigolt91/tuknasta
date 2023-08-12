<?php

namespace App\Policies;

use App\Models\User;

class UserRolePolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(['administrator', 'editor']);
    }

    public function update(User $user): bool
    {
        return $user->hasRole(['administrator', 'editor']);
    }

    public function delete(User $user): bool
    {
        return $user->hasRole(['administrator', 'editor']);
    }
}
