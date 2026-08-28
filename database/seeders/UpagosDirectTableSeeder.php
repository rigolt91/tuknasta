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
            'phone' => '+1 555 0100',
            'email' => 'info@marketplace.example.com',
            'facebook' => 'https://www.facebook.com/',
            'instagram' => 'https://www.instagram.com/',
            'twitter' => 'https://twitter.com',
            'linkedin' => 'https://www.linkedin.com',
            'google' => 'https://www.google.com',
        ]);
    }
}
