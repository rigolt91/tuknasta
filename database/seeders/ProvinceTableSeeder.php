<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            'Pinar del Río',
            'Artemisa',
            'La Habana',
            'Mayabeque',
            'Matanzas',
            'Cienfuegos',
            'Villa Clara',
            'Sancti Spíritus',
            'Ciego de Ávila',
            'Camagüey',
            'Las Tunas',
            'Holguín',
            'Granma',
            'Santiago de Cuba',
            'Guantánamo',
            'Isla de la Juventud',
        ];

        $this->create($provinces);
    }

    public function create($provinces)
    {
        foreach ($provinces as $province) {
            Province::create(['name' => $province]);
        }
    }
}
