<?php

namespace App\Repositories;

use App\Models\User;

trait UserRepository
{
    public $rules = [

    ];

    public function create()
    {

    }

    public function disabled(User $user)
    {
        return $user->update(['disabled' => !$user->disabled]);
    }
}
