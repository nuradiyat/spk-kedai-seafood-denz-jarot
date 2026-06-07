<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
       
        Karyawan::insert([
            ['nama_karyawan' => 'Maliah', 'jabatan' => 'Kasir', 'tanggal_masuk' => '2020-01-01'],
            ['nama_karyawan' => 'Sari', 'jabatan' => 'Chef', 'tanggal_masuk' => '2020-03-01'],
            ['nama_karyawan' => 'Dewi', 'jabatan' => 'Pelayan', 'tanggal_masuk' => '2021-02-01'],
            ['nama_karyawan' => 'Ilham', 'jabatan' => 'Chef', 'tanggal_masuk' => '2021-04-01'],
            ['nama_karyawan' => 'Imel', 'jabatan' => 'Pelayan', 'tanggal_masuk' => '2022-06-01'],
            ['nama_karyawan' => 'Riki', 'jabatan' => 'Pelayan', 'tanggal_masuk' => '2022-01-01'],
        ]);
    }
}
