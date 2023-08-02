<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electrodomésticos'],
            ['name' => 'Equipo eléctrico de respaldo'],
            ['name' => 'Teléfonos celulares y accesorios'],
            ['name' => 'Computadoras y accesorios'],
            ['name' => 'Ferretería'],
            ['name' => 'Transporte'],
            ['name' => 'Insumos para la agricultura'],
            ['name' => 'Comida'],
            ['name' => 'Higiene personal'],
            ['name' => 'Home'],
            ['name' => 'Flores y regalos'],
        ];

        foreach($categories as $category)
        {
            Category::create($category);
        }
    }
}
