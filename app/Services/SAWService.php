<?php

namespace App\Services;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\DetailPenilaian;
use App\Models\HasilSaw;

class SAWService
{
    /**
     * ==================================================
     * MAIN PROCESS
     * ================================================z==
     */
    public function calculate($penilaianId)
    {
        $data = $this->hitung($penilaianId);

        $ranking = $data['ranking'];
        $rank = 1;

        foreach ($ranking as $karyawanId => $nilai) {

            HasilSaw::updateOrCreate(
                [
                    'penilaian_id' => $penilaianId,
                    'karyawan_id'  => $karyawanId,
                ],
                [
                    'nilai_akhir' => $nilai,
                    'ranking'     => $rank,
                    'status_bonus' => $rank === 1 ? 'Diterima' : 'Tidak',
                ]
            );

            $rank++;
        }

        return $data;
    }

    /**
     * ==================================================
     * HITUNG SAW
     * ==================================================
     */
    public function hitung($penilaianId)
    {
        $karyawans = Karyawan::all();
        $kriterias = Kriteria::all();

        /**
         * ==================================================
         * AMBIL DATA SEKALI (OPTIMIZED)
         * ==================================================
         */
        $rawData = DetailPenilaian::where('penilaian_id', $penilaianId)
            ->get()
            ->groupBy(['karyawan_id', 'kriteria_id']);

        /**
         * ==================================================
         * 1. MATRIX
         * ==================================================
         */
        $matrix = [];

        foreach ($karyawans as $karyawan) {
            foreach ($kriterias as $kriteria) {

                $matrix[$karyawan->id][$kriteria->id] =
                    $rawData[$karyawan->id][$kriteria->id][0]->nilai ?? 0;
            }
        }

        /**
         * ==================================================
         * 2. MAX & MIN
         * ==================================================
         */
        $max = [];
        $min = [];

        foreach ($kriterias as $kriteria) {

            $values = array_column($matrix, $kriteria->id);

            $max[$kriteria->id] = max($values);
            $min[$kriteria->id] = min($values);
        }

        /**
         * ==================================================
         * 3. NORMALISASI (SAW STANDARD)
         * ==================================================
         */
        $normalisasi = [];

        foreach ($karyawans as $karyawan) {
            foreach ($kriterias as $kriteria) {

                $value = $matrix[$karyawan->id][$kriteria->id];

                if ($kriteria->jenis === 'benefit') {
                    $normalisasi[$karyawan->id][$kriteria->id] =
                        $max[$kriteria->id] != 0
                        ? $value / $max[$kriteria->id]
                        : 0;
                } else {
                    $normalisasi[$karyawan->id][$kriteria->id] =
                        $value != 0
                        ? $min[$kriteria->id] / $value
                        : 0;
                }
            }
        }

        /**
         * ==================================================
         * 4. BOBOT (NORMALIZED)
         * ==================================================
         */
        $totalBobot = $kriterias->sum('bobot');

        $bobot = [];

        foreach ($kriterias as $kriteria) {
            $bobot[$kriteria->id] =
                $totalBobot > 0
                ? $kriteria->bobot / $totalBobot
                : 0;
        }

        /**
         * ==================================================
         * 5. MATRIX TERBOBOT
         * ==================================================
         */
        $terbobot = [];

        foreach ($karyawans as $karyawan) {
            foreach ($kriterias as $kriteria) {

                $terbobot[$karyawan->id][$kriteria->id] =
                    $normalisasi[$karyawan->id][$kriteria->id]
                    * $bobot[$kriteria->id];
            }
        }

        /**
         * ==================================================
         * 6. NILAI AKHIR (V)
         * ==================================================
         */
        $nilaiAkhir = [];

        foreach ($karyawans as $karyawan) {

            $nilaiAkhir[$karyawan->id] = array_sum(
                $terbobot[$karyawan->id]
            );
        }

        /**
         * ==================================================
         * 7. RANKING (DESC)
         * ==================================================
         */
        arsort($nilaiAkhir);

        return [
            'matrix'        => $matrix,
            'max'           => $max,
            'min'           => $min,
            'normalisasi'   => $normalisasi,
            'bobot'         => $bobot,
            'terbobot'      => $terbobot,
            'nilai_akhir'   => $nilaiAkhir,
            'ranking'       => $nilaiAkhir,
        ];
    }
}
