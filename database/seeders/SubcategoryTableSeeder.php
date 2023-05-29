<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            ['name' => 'Coffee, Tea', 'category_id' => 1],
            ['name' => 'Blenders', 'category_id' => 1],
            ['name' => 'Fryers', 'category_id' => 1],
            ['name' => 'Cooking equipment', 'category_id' => 1],
            ['name' => 'Turbines and electric motors', 'category_id' => 1],
            ['name' => 'Washing machines', 'category_id' => 1],
            ['name' => 'Climate and ventilation equipment', 'category_id' => 1],
            ['name' => 'Refrigerators', 'category_id' => 1],
            ['name' => 'Electrical backup equipment', 'category_id' => 2],
            ['name' => 'Cell phones and accessories', 'category_id' => 3],
            ['name' => 'Computers and accessories', 'category_id' => 4],
            ['name' => 'Hand tools', 'category_id' => 5],
            ['name' => 'Paintings', 'category_id' => 5],
            ['name' => 'Construction materials', 'category_id' => 5],
            ['name' => 'Parts and motorcycle parts', 'category_id' => 6],
            ['name' => 'Car accessories', 'category_id' => 6],
            ['name' => 'Inputs for agriculture', 'category_id' => 7],
            ['name' => 'Meats', 'category_id' => 8],
            ['name' => 'Sausages and smoked', 'category_id' => 8],
            ['name' => 'Oils and fats', 'category_id' => 8],
            ['name' => 'Seasonings', 'category_id' => 8],
            ['name' => 'Preserves', 'category_id' => 8],
            ['name' => 'Dairy', 'category_id' => 8],
            ['name' => 'Pasta, grains and cereals', 'category_id' => 8],
            ['name' => 'Root vegetables, fruits and vegetables', 'category_id' => 8],
            ['name' => 'Personal hygiene', 'category_id' => 9],
            ['name' => 'Home furnishings', 'category_id' => 10],
            ['name' => 'Flowers and gift', 'category_id' => 11],
        ];

        foreach($subcategories as $subcategory)
        {
            Subcategory::create($subcategory);
        }
    }
}
