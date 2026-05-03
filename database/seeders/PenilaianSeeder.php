<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penilaian;

class PenilaianSeeder extends Seeder
{
    public function run(): void
    {
        Penilaian::create([
            'user_id' => 2, 
            'periode' => 'Mei 2026',
            'tanggal_penilaian' => '2026-05-01'
        ]);
    }
}