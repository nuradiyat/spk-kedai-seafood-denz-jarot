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
                    'id_karyawan' => $k->id,
                    'id_kriteria' => $kr->id
                ])->value('nilai');

                $matrix[$k->id][$kr->id] = $nilai ?? 0;
            }
        }

        // ========================
        // 2. MAX / MIN
        // ========================
        $max = [];
        $min = [];

        foreach ($kriteria as $kr) {
            $values = array_column($matrix, $kr->id);

            $max[$kr->id] = max($values);
            $min[$kr->id] = min($values);
        }

        // ========================
        // 3. NORMALISASI
        // ========================
        $normalisasi = [];

        foreach ($kriteria as $kr) {
            foreach ($karyawan as $k) {

                $value = $matrix[$k->id][$kr->id];

                if ($kr->jenis == 'benefit') {
                    $normalisasi[$k->id][$kr->id] =
                        $value / ($max[$kr->id] ?: 1);
                } else {
                    $normalisasi[$k->id][$kr->id] =
                        ($min[$kr->id] ?: 1) / ($value ?: 1);
                }
            }
        }

        // ========================
        // 4. BOBOT
        // ========================
        $bobot = [];
        foreach ($kriteria as $kr) {
            $bobot[$kr->id] = $kr->bobot;
        }

        // ========================
        // 5. TERBOBOT
        // ========================
        $terbobot = [];

        foreach ($karyawan as $k) {
            foreach ($kriteria as $kr) {

                $terbobot[$k->id][$kr->id] =
                    $normalisasi[$k->id][$kr->id] * $kr->bobot;
            }
        }

        // ========================
        // 6. NILAI AKHIR
        // ========================
        $nilaiAkhir = [];

        foreach ($karyawan as $k) {
            $total = array_sum($terbobot[$k->id]);
            $nilaiAkhir[$k->id] = $total;
        }

        // ========================
        // 7. RANKING
        // ========================
        arsort($nilaiAkhir);

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
            'ranking'      => $nilaiAkhir,
        ];
    }
}
