<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        Kriteria::insert([
    [
        'kode' => 'C1',
        'nama_kriteria' => 'Pencapaian Target',
        'bobot' => 0.30,
        'jenis' => 'benefit'
    ],
    [
        'kode' => 'C2',
        'nama_kriteria' => 'Produktivitas Kerja',
        'bobot' => 0.30,
        'jenis' => 'benefit'
    ],
    [
        'kode' => 'C3',
        'nama_kriteria' => 'Kehadiran',
        'bobot' => 0.20,
        'jenis' => 'benefit'
    ],
    [
        'kode' => 'C4',
        'nama_kriteria' => 'Pelayanan Pelanggan',
        'bobot' => 0.20,
        'jenis' => 'benefit'
    ],
]);
    }
}