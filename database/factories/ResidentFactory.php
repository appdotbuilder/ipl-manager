<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bloks = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'D1', 'D2'];
        $nominalOptions = [60000, 75000, 90000];
        
        return [
            'nama_warga' => $this->faker->name(),
            'blok_nomor_rumah' => $this->faker->randomElement($bloks) . '/No.' . $this->faker->numberBetween(1, 20),
            'default_nominal_ipl' => $this->faker->randomElement($nominalOptions),
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the resident is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}