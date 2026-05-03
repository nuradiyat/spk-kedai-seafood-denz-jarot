<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailPenilaian;

class DetailPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        DetailPenilaian::insert([
            // ANDI
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>1,'nilai'=>80],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>2,'nilai'=>70],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>3,'nilai'=>90],
            ['penilaian_id'=>1,'karyawan_id'=>1,'kriteria_id'=>4,'nilai'=>85],

            // BUDI
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>1,'nilai'=>60],
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>2,'nilai'=>75],
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>3,'nilai'=>80],
            ['penilaian_id'=>1,'karyawan_id'=>2,'kriteria_id'=>4,'nilai'=>70],

            // CITRA
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>1,'nilai'=>90],
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>2,'nilai'=>85],
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>3,'nilai'=>95],
            ['penilaian_id'=>1,'karyawan_id'=>3,'kriteria_id'=>4,'nilai'=>88],
        ]);
    }
}