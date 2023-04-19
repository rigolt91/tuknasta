<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create User for Administration
        $administrator = User::create([
            'name'     => 'Administrator',
            'last_name' => 'TuKanasta',
            'email'    => 'tukanasta@nauta.cu',
            'password' => bcrypt('tukanasta'),
            'email_verified_at' => date('Y-m-d h:m:s'),
        ]);

        //Create User for Editing
        $administrator->assignRole('administrator');
    }
}
