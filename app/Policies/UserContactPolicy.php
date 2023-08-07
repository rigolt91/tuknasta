<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;

class UserContactPolicy
{
    public function update(User $user, UserContact $userContact): bool
    {
        return $user->id === $userContact->user_id;
    }

    public function delete(User $user, UserContact $userContact): bool
    {
        return $user->id === $userContact->user_id;
    }
}
