<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailPenilaian;

class DetailPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        DetailPenilaian::insert([
            // IMEL (ID: 1)
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>1,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>2,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>3,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>4,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>5,'nilai'=>5],

            // RIKI (ID: 2)
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>1,'nilai'=>3],
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>2,'nilai'=>2],
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>3,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>4,'nilai'=>3],
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>5,'nilai'=>3],

            // SARI (ID: 3)
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>1,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>2,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>3,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>4,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>5,'nilai'=>4],

            // ILHAM (ID: 4)
            ['penilaian_id'=>1,'karyawan_id'=>4,'kriteria_id'=>1,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>4,'kriteria_id'=>2,'nilai'=>3],
            ['penilaian_id'=>1,'karyawan_id'=>4,'kriteria_id'=>3,'nilai'=>5],
            ['penilaian_id'=>1,'karyawan_id'=>4,'kriteria_id'=>4,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>4,'kriteria_id'=>5,'nilai'=>4],

            // SINDI (ID: 5)
            ['penilaian_id'=>1,'karyawan_id'=>5,'kriteria_id'=>1,'nilai'=>3],
            ['penilaian_id'=>1,'karyawan_id'=>5,'kriteria_id'=>2,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>5,'kriteria_id'=>3,'nilai'=>3],
            ['penilaian_id'=>1,'karyawan_id'=>5,'kriteria_id'=>4,'nilai'=>4],
            ['penilaian_id'=>1,'karyawan_id'=>5,'kriteria_id'=>5,'nilai'=>3],
        ]);
    }
}