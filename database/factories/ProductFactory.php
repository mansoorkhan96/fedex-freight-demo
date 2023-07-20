<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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
            'sku' => strtoupper(Str::random(8)),
            'name' => fake()->sentence(),
            'price' => random_int(20, 100),
            'product_image' => fake()->imageUrl,
            'upc' => strtoupper(Str::random()),
            'uom' => 'Pack of 3',
            'freight_data' => [],
        ];
    }
}
