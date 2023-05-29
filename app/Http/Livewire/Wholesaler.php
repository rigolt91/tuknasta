<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Wholesaler extends Component
{
    public function render()
    {
        return view('livewire.wholesaler', [
            'email' => User::where('name', 'Administrator')->select('email')->first()->email,
        ]);
    }
}
