<?php

namespace Database\Factories;

use App\Models\Municipality;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'dni' => $this->faker->numerify('###########'),
            'phone' => $this->faker->phoneNumber(),
            'street' => $this->faker->streetName(),
            'between_streets' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'province_id' => Province::factory(),
            'municipality_id' => Municipality::factory(),
            'prefer' => true,
        ];
    }
}
