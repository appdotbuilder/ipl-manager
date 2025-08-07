<?php

namespace Database\Seeders;

use App\Models\Resident;
use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = [
            // Blok A
            ['nama_warga' => 'Budi Santoso', 'blok_nomor_rumah' => 'A1/No.1', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Siti Aminah', 'blok_nomor_rumah' => 'A1/No.2', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Ahmad Rahman', 'blok_nomor_rumah' => 'A1/No.3', 'default_nominal_ipl' => 75000],
            ['nama_warga' => 'Maya Sari', 'blok_nomor_rumah' => 'A1/No.4', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Eko Prasetyo', 'blok_nomor_rumah' => 'A1/No.5', 'default_nominal_ipl' => 60000],
            
            // Blok B
            ['nama_warga' => 'Dewi Lestari', 'blok_nomor_rumah' => 'B2/No.1', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Hendra Wijaya', 'blok_nomor_rumah' => 'B2/No.2', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Linda Permata', 'blok_nomor_rumah' => 'B2/No.3', 'default_nominal_ipl' => 75000],
            ['nama_warga' => 'Ridwan Kamil', 'blok_nomor_rumah' => 'B2/No.4', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Nurul Hidayah', 'blok_nomor_rumah' => 'B2/No.5', 'default_nominal_ipl' => 90000],
            
            // Blok C
            ['nama_warga' => 'Bambang Sutrisno', 'blok_nomor_rumah' => 'C3/No.1', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Rina Marlina', 'blok_nomor_rumah' => 'C3/No.2', 'default_nominal_ipl' => 60000],
            ['nama_warga' => 'Agus Salim', 'blok_nomor_rumah' => 'C3/No.3', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Fitri Handayani', 'blok_nomor_rumah' => 'C3/No.4', 'default_nominal_ipl' => 75000],
            ['nama_warga' => 'Doni Saputra', 'blok_nomor_rumah' => 'C3/No.5', 'default_nominal_ipl' => 90000],
            
            // Blok D
            ['nama_warga' => 'Sri Mulyani', 'blok_nomor_rumah' => 'D1/No.1', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Joko Widodo', 'blok_nomor_rumah' => 'D1/No.2', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Mega Wati', 'blok_nomor_rumah' => 'D1/No.3', 'default_nominal_ipl' => 75000],
            ['nama_warga' => 'Prabowo Subianto', 'blok_nomor_rumah' => 'D1/No.4', 'default_nominal_ipl' => 90000],
            ['nama_warga' => 'Ganjar Pranowo', 'blok_nomor_rumah' => 'D1/No.5', 'default_nominal_ipl' => 60000],
        ];

        foreach ($residents as $resident) {
            Resident::create($resident);
        }
    }
}