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
            'last_name' => 'TuKnasta',
            'email'    => 'admin@tuknasta.com',
            'password' => bcrypt('TUknasta*/2023'),
            'email_verified_at' => date('Y-m-d h:m:s'),
        ]);

        //Create User for Editing
        $administrator->assignRole('administrator');
    }
}
