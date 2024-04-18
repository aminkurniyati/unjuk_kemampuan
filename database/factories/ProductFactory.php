<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'nama' => fake()->word(2),
            'foto' => fake()->imageUrl(360, 360, 'animal', true, 'cat', true, 'jpg'),
            'harga' => 100,
            'deskripsi' => fake()->sentence(5),
        ];
    }
}
