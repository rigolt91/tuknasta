<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UpagosDirect;

class UpagosDirectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UpagosDirect::create([
            'phone' => '+15622201521',
            'email' => 'info.tuknasta@gmail.com',
            'facebook' => 'https://www.facebook.com/',
            'instagram' => 'https://www.instagram.com/',
            'twitter' => 'https://twitter.com',
            'linkedin' => 'https://www.linkedin.com',
            'google' => 'https://www.google.com',
        ]);
    }
}
