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
            ['name' => 'Home appliances'],
            ['name' => 'Electrical backup equipment'],
            ['name' => 'Cell phones and accessories'],
            ['name' => 'Computers and accessories'],
            ['name' => 'Hardware store'],
            ['name' => 'Transport'],
            ['name' => 'Inputs for agriculture'],
            ['name' => 'Food'],
            ['name' => 'Personal hygiene'],
            ['name' => 'Home'],
            ['name' => 'Flowers and gifts'],
        ];

        foreach($categories as $category)
        {
            Category::create($category);
        }
    }
}
