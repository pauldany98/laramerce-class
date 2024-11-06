<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Laptop',
                'Desktop',
                'Mobile',
                'Tablet',
                'Smartwatch',
                'Headphone',
                'Earphone',
                'Keyboard',
                'Mouse',
                'Monitor',
            ]),
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
