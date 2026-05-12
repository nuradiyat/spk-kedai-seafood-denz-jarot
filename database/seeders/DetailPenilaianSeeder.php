<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailPenilaian;

class DetailPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        DetailPenilaian::insert([
            // IMEL
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>1,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>2,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>3,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>4,'nilai'=>4],

            // RIKI
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>1,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>2,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>3,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>4,'nilai'=>4],

            // SARI
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>1,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>2,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>3,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>4,'nilai'=>4],

            // ILHAM
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>1,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>2,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>3,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>4,'nilai'=>4],

            // SINDI
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>1,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>2,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>3,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>4,'nilai'=>4],
        ]);
    }
}