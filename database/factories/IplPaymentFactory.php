<?php

namespace Database\Factories;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IplPayment>
 */
class IplPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $months = [
            'januari', 'februari', 'maret', 'april', 'mei', 'juni',
            'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
        ];
        
        $nominalOptions = [60000, 75000, 90000];
        
        return [
            'nomor' => $this->faker->unique()->numberBetween(1, 10000),
            'resident_id' => Resident::factory(),
            'nominal_ipl' => $this->faker->randomElement($nominalOptions),
            'tahun_periode' => $this->faker->numberBetween(2023, 2025),
            'bulan_ipl' => $this->faker->randomElement($months),
            'status_pembayaran' => $this->faker->randomElement(['paid', 'unpaid', 'exempt']),
            'rumah_kosong' => $this->faker->boolean(10), // 10% chance
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the payment is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_pembayaran' => 'paid',
        ]);
    }

    /**
     * Indicate that the payment is unpaid.
     */
    public function unpaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_pembayaran' => 'unpaid',
        ]);
    }

    /**
     * Indicate that the payment is for an empty house.
     */
    public function emptyHouse(): static
    {
        return $this->state(fn (array $attributes) => [
            'rumah_kosong' => true,
            'status_pembayaran' => 'exempt',
        ]);
    }
}