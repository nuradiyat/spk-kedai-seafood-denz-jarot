<?php

namespace App\Services;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\DetailPenilaian;
use App\Models\HasilSaw;

class SAWService
{
    public function calculate($id_penilaian)
    {
        $karyawan = Karyawan::all();
        $kriteria = Kriteria::all();

        // Ambil nilai
        $matrix = [];
        foreach ($karyawan as $k) {
            foreach ($kriteria as $kr) {
                $nilai = DetailPenilaian::where([
                    'id_penilaian' => $id_penilaian,
                    'id_karyawan' => $k->id_karyawan,
                    'id_kriteria' => $kr->id_kriteria
                ])->value('nilai');

                $matrix[$k->id_karyawan][$kr->id_kriteria] = $nilai ?? 0;
            }
        }

        // Normalisasi
        $normalisasi = [];
        foreach ($kriteria as $kr) {
            $values = array_column($matrix, $kr->id_kriteria);

            $max = max($values);
            $min = min($values);

            foreach ($karyawan as $k) {
                $value = $matrix[$k->id_karyawan][$kr->id_kriteria];

                if ($kr->jenis == 'benefit') {
                    $normalisasi[$k->id_karyawan][$kr->id_kriteria] = $value / ($max ?: 1);
                } else {
                    $normalisasi[$k->id_karyawan][$kr->id_kriteria] = ($min ?: 1) / ($value ?: 1);
                }
            }
        }

        // Hitung nilai akhir
        $hasil = [];
        foreach ($karyawan as $k) {
            $total = 0;

            foreach ($kriteria as $kr) {
                $total += $normalisasi[$k->id_karyawan][$kr->id_kriteria] * $kr->bobot;
            }

            $hasil[$k->id_karyawan] = $total;
        }

        // Ranking
        arsort($hasil);
        $ranking = 1;

        foreach ($hasil as $id_karyawan => $nilai_akhir) {
            HasilSaw::updateOrCreate(
                [
                    'id_penilaian' => $id_penilaian,
                    'id_karyawan' => $id_karyawan
                ],
                [
                    'nilai_akhir' => $nilai_akhir,
                    'ranking' => $ranking,
                    'status_bonus' => $ranking == 1 ? 'Diterima' : 'Tidak'
                ]
            );

            $ranking++;
        }

        return $hasil;
    }
}