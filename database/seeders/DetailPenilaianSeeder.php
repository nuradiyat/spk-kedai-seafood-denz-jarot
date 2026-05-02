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
            ['id_penilaian'=>1,'id_karyawan'=>1,'id_kriteria'=>1,'nilai'=>80],
            ['id_penilaian'=>1,'id_karyawan'=>1,'id_kriteria'=>2,'nilai'=>70],
            ['id_penilaian'=>1,'id_karyawan'=>1,'id_kriteria'=>3,'nilai'=>90],
            ['id_penilaian'=>1,'id_karyawan'=>1,'id_kriteria'=>4,'nilai'=>85],

            // BUDI
            ['id_penilaian'=>1,'id_karyawan'=>2,'id_kriteria'=>1,'nilai'=>60],
            ['id_penilaian'=>1,'id_karyawan'=>2,'id_kriteria'=>2,'nilai'=>75],
            ['id_penilaian'=>1,'id_karyawan'=>2,'id_kriteria'=>3,'nilai'=>80],
            ['id_penilaian'=>1,'id_karyawan'=>2,'id_kriteria'=>4,'nilai'=>70],

            // CITRA
            ['id_penilaian'=>1,'id_karyawan'=>3,'id_kriteria'=>1,'nilai'=>90],
            ['id_penilaian'=>1,'id_karyawan'=>3,'id_kriteria'=>2,'nilai'=>85],
            ['id_penilaian'=>1,'id_karyawan'=>3,'id_kriteria'=>3,'nilai'=>95],
            ['id_penilaian'=>1,'id_karyawan'=>3,'id_kriteria'=>4,'nilai'=>88],
        ]);
    }
}