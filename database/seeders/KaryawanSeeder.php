<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        Karyawan::insert([
            ['nama_karyawan' => 'Andi'],
            ['nama_karyawan' => 'Budi'],
            ['nama_karyawan' => 'Citra'],
        ]);
    }
}