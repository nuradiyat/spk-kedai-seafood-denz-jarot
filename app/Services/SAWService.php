<?php

namespace App\Services;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\DetailPenilaian;
use App\Models\HasilSaw;

class SAWService
{
    /**
     * ==========================================
     * HITUNG SAW + SIMPAN KE DATABASE
     * ==========================================
     */
    public function calculate($penilaianId)
    {
        $data = $this->hitung($penilaianId);

        $ranking = 1;

        foreach ($data['ranking'] as $karyawanId => $nilaiAkhir) {

            HasilSaw::updateOrCreate(
                [
                    'penilaian_id' => $penilaianId,
                    'karyawan_id' => $karyawanId,
                ],
                [
                    'nilai_akhir' => $nilaiAkhir,
                    'ranking' => $ranking,
                    'status_bonus' => $ranking == 1
                        ? 'Diterima'
                        : 'Tidak',
                ]
            );

            $ranking++;
        }

        return true;
    }

    /**
     * ==========================================
     * HITUNG METODE SAW
     * ==========================================
     */
    public function hitung($penilaianId)
    {
        /**
         * ==========================
         * AMBIL DATA
         * ==========================
         */
        $karyawans = Karyawan::all();

        $kriterias = Kriteria::all();

        /**
         * ==========================
         * 1. MATRIX NILAI AWAL
         * ==========================
         */
        $matrix = [];

        foreach ($karyawans as $karyawan) {

            foreach ($kriterias as $kriteria) {

                $nilai = DetailPenilaian::where([
                    'penilaian_id' => $penilaianId,
                    'karyawan_id' => $karyawan->id,
                    'kriteria_id' => $kriteria->id,
                ])->value('nilai');

                $matrix[$karyawan->id][$kriteria->id] = $nilai ?? 0;
            }
        }

        /**
         * ==========================
         * 2. MAX & MIN
         * ==========================
         */
        $max = [];

        $min = [];

        foreach ($kriterias as $kriteria) {

            $values = array_column(
                $matrix,
                $kriteria->id
            );

            $max[$kriteria->id] = max($values);

            $min[$kriteria->id] = min($values);
        }

        /**
         * ==========================
         * 3. NORMALISASI
         * ==========================
         */
        $normalisasi = [];

        foreach ($kriterias as $kriteria) {

            foreach ($karyawans as $karyawan) {

                $value = $matrix[$karyawan->id][$kriteria->id];

                /**
                 * BENEFIT
                 */
                if ($kriteria->jenis == 'benefit') {

                    $normalisasi[$karyawan->id][$kriteria->id] =
                        $value / ($max[$kriteria->id] ?: 1);
                }

                /**
                 * COST
                 */
                else {

                    $normalisasi[$karyawan->id][$kriteria->id] =
                        ($min[$kriteria->id] ?: 1) / ($value ?: 1);
                }
            }
        }

        /**
         * ==========================
         * 4. BOBOT KRITERIA
         * ==========================
         */
        $bobot = [];

        foreach ($kriterias as $kriteria) {

            $bobot[$kriteria->id] = $kriteria->bobot;
        }

        /**
         * ==========================
         * 5. MATRIX TERBOBOT
         * ==========================
         */
        $terbobot = [];

        foreach ($karyawans as $karyawan) {

            foreach ($kriterias as $kriteria) {

                $terbobot[$karyawan->id][$kriteria->id] =
                    $normalisasi[$karyawan->id][$kriteria->id]
                    * $kriteria->bobot;
            }
        }

        /**
         * ==========================
         * 6. NILAI AKHIR
         * ==========================
         */
        $nilaiAkhir = [];

        foreach ($karyawans as $karyawan) {

            $total = array_sum(
                $terbobot[$karyawan->id]
            );

            $nilaiAkhir[$karyawan->id] = $total;
        }

        /**
         * ==========================
         * 7. RANKING
         * ==========================
         */
        arsort($nilaiAkhir);

        $ranking = $nilaiAkhir;

        /**
         * ==========================
         * RETURN DATA
         * ==========================
         */
        return [
            'karyawans'     => $karyawans,
            'kriterias'     => $kriterias,
            'nilai_awal'    => $matrix,
            'max'           => $max,
            'min'           => $min,
            'normalisasi'   => $normalisasi,
            'bobot'         => $bobot,
            'terbobot'      => $terbobot,
            'nilai_akhir'   => $nilaiAkhir,
            'ranking'       => $ranking,
        ];
    }
}