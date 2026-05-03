<?php

namespace App\Services;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\DetailPenilaian;
use App\Models\HasilSaw;

class SAWService
{
    /**
     * 📌 HITUNG SAW + SIMPAN KE DATABASE
     */
    public function calculate($id_penilaian)
    {
        $data = $this->hitung($id_penilaian);

        $ranking = 1;

        foreach ($data['ranking'] as $id_karyawan => $nilai_akhir) {

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

        return true;
    }

    /**
     * 📌 HITUNG SAW (UNTUK VIEW DETAIL)
     */
    public function hitung($id_penilaian)
    {
        $karyawan = Karyawan::all();
        $kriteria = Kriteria::all();

        // ========================
        // 1. MATRIX NILAI AWAL
        // ========================
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

        // ========================
        // 2. MAX / MIN
        // ========================
        $max = [];
        $min = [];

        foreach ($kriteria as $kr) {
            $values = array_column($matrix, $kr->id_kriteria);

            $max[$kr->id_kriteria] = max($values);
            $min[$kr->id_kriteria] = min($values);
        }

        // ========================
        // 3. NORMALISASI
        // ========================
        $normalisasi = [];

        foreach ($kriteria as $kr) {
            foreach ($karyawan as $k) {

                $value = $matrix[$k->id_karyawan][$kr->id_kriteria];

                if ($kr->jenis == 'benefit') {
                    $normalisasi[$k->id_karyawan][$kr->id_kriteria] =
                        $value / ($max[$kr->id_kriteria] ?: 1);
                } else {
                    $normalisasi[$k->id_karyawan][$kr->id_kriteria] =
                        ($min[$kr->id_kriteria] ?: 1) / ($value ?: 1);
                }
            }
        }

        // ========================
        // 4. BOBOT
        // ========================
        $bobot = [];
        foreach ($kriteria as $kr) {
            $bobot[$kr->id_kriteria] = $kr->bobot;
        }

        // ========================
        // 5. TERBOBOT
        // ========================
        $terbobot = [];

        foreach ($karyawan as $k) {
            foreach ($kriteria as $kr) {

                $terbobot[$k->id_karyawan][$kr->id_kriteria] =
                    $normalisasi[$k->id_karyawan][$kr->id_kriteria] * $kr->bobot;
            }
        }

        // ========================
        // 6. NILAI AKHIR
        // ========================
        $nilaiAkhir = [];

        foreach ($karyawan as $k) {
            $total = array_sum($terbobot[$k->id_karyawan]);
            $nilaiAkhir[$k->id_karyawan] = $total;
        }

        // ========================
        // 7. RANKING
        // ========================
        arsort($nilaiAkhir);
        $ranking = $nilaiAkhir;

        return [
            'karyawan'     => $karyawan,
            'kriteria'     => $kriteria,
            'nilai_awal'   => $matrix,
            'max'          => $max,
            'min'          => $min,
            'normalisasi'  => $normalisasi,
            'bobot'        => $bobot,
            'terbobot'     => $terbobot,
            'nilai_akhir'  => $nilaiAkhir,
            'ranking'      => $ranking,
        ];
    }
}