<?php

namespace Database\Factories;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 100),
            'cost' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => User::factory(),
        ];
    }
}
