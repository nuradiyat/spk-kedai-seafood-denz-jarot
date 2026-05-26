<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        Karyawan::insert([
            ['nama_karyawan' => 'Imel'],
            ['nama_karyawan' => 'Sari'],
            ['nama_karyawan' => 'Maliah'],
            ['nama_karyawan' => 'Riki'],
            ['nama_karyawan' => 'Ilham'],
        ]);
    }
}