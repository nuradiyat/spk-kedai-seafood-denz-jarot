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
        'nama_kriteria' => 'Tingkat Kehadiran',
        'bobot' => 0.25,
        'jenis' => 'benefit'
    ],
    [
        'kode' => 'C2',
        'nama_kriteria' => 'Produktivitas Kerja',
        'bobot' => 0.25,
        'jenis' => 'benefit'
    ],
    [
        'kode' => 'C3',
        'nama_kriteria' => 'Kemampuan Kerja Sama Tim',
        'bobot' => 0.20,
        'jenis' => 'benefit'
    ],
    [
        'kode' => 'C4',
        'nama_kriteria' => 'Tanggung Jawab Kerja',
        'bobot' => 0.15,
        'jenis' => 'benefit'
    ],
    [
        'kode' => 'C5',
        'nama_kriteria' => 'Masa Kerja Karyawan',
        'bobot' => 0.15,
        'jenis' => 'benefit'
    ],
]);
    }
}