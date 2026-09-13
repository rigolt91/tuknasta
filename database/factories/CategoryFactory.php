<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'image' => 'categories/placeholder.png',
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'show' => true,
        ];
    }
}
