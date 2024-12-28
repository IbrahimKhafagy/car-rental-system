<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement(['Sedan', 'SUV', 'Truck']),
            'price_per_day' => $this->faker->randomFloat(2, 50, 500),
            'availability_status' => true,
        ];

    }
}
