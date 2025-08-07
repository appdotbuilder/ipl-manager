<?php

namespace Database\Seeders;

use App\Models\IplPayment;
use App\Models\Resident;
use Illuminate\Database\Seeder;

class IplPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = Resident::all();
        $months = [
            'januari', 'februari', 'maret', 'april', 'mei', 'juni',
            'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
        ];
        $currentYear = 2024;
        $nomor = 1;

        foreach ($residents as $resident) {
            // Create payments for some months of 2024
            $paidMonths = array_slice($months, 0, random_int(6, 10)); // Random 6-10 months paid
            
            foreach ($paidMonths as $month) {
                $isPaid = random_int(1, 10) > 2; // 80% chance of being paid
                $isOverdue = !$isPaid && random_int(1, 10) > 7; // Some overdue payments
                
                IplPayment::create([
                    'nomor' => $nomor++,
                    'resident_id' => $resident->id,
                    'nominal_ipl' => $resident->default_nominal_ipl,
                    'tahun_periode' => $currentYear,
                    'bulan_ipl' => $month,
                    'status_pembayaran' => $isPaid ? 'paid' : 'unpaid',
                    'rumah_kosong' => random_int(1, 20) === 1, // 5% chance of being empty house
                    'created_at' => $isOverdue 
                        ? now()->subMonths(random_int(3, 6)) // Overdue payments are older
                        : now()->subDays(random_int(1, 30)),
                ]);
            }
        }
    }
}