<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'image' => 'products/placeholder.png',
            'name' => $name,
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-####')),
            'slug' => Str::slug($name).'-'.$this->faker->unique()->numberBetween(1, 100000),
            'short_description' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 200),
            'previous_price' => null,
            'stock' => $this->faker->numberBetween(10, 100),
            'show' => true,
            'recommend' => false,
            'category_id' => Category::factory(),
            'subcategory_id' => Subcategory::factory(),
            'branch_id' => Branch::factory(),
        ];
    }
}
