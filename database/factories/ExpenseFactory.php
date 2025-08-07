<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Kebersihan',
            'Keamanan', 
            'Pemeliharaan Taman',
            'Listrik',
            'Air',
            'Perbaikan Jalan',
            'Administrasi',
            'Lain-lain'
        ];

        $descriptions = [
            'Gaji petugas kebersihan',
            'Gaji satpam',
            'Pembelian tanaman hias',
            'Pembayaran listrik umum',
            'Pembayaran PAM',
            'Perbaikan jalan rusak',
            'Biaya administrasi',
            'Pembelian alat kebersihan'
        ];
        
        return [
            'description' => $this->faker->randomElement($descriptions),
            'amount' => $this->faker->numberBetween(100000, 2000000),
            'expense_date' => $this->faker->dateTimeThisYear(),
            'category' => $this->faker->randomElement($categories),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}