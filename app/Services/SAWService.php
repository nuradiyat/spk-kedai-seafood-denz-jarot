<?php

namespace App\Services;

use App\Models\Penilaian;
use App\Models\Kriteria;
use App\Models\HasilSaw;
use Illuminate\Support\Facades\DB;

class SAWService
{
    /**
     * Jalankan proses SAW
     */
    public function hitung(Penilaian $penilaian)
    {
        DB::transaction(function () use ($penilaian) {

            /*
            |--------------------------------------------------------------------------
            | Ambil Semua Kriteria
            |--------------------------------------------------------------------------
            */
            $kriterias = Kriteria::all();

            /*
            |--------------------------------------------------------------------------
            | Ambil Semua Detail Penilaian
            |--------------------------------------------------------------------------
            */
            $details = $penilaian->detailPenilaians()
                ->with(['karyawan', 'kriteria'])
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Bentuk Matriks Keputusan
            |--------------------------------------------------------------------------
            */
            $matrix = [];

            foreach ($details as $detail) {

                $matrix[$detail->karyawan_id][$detail->kriteria_id]
                    = $detail->nilai;
            }

            /*
            |--------------------------------------------------------------------------
            | Cari Nilai Max / Min
            |--------------------------------------------------------------------------
            */
            $maxMin = [];

            foreach ($kriterias as $kriteria) {

                $nilaiKriteria = [];

                foreach ($matrix as $karyawan) {

                    $nilaiKriteria[] =
                        $karyawan[$kriteria->id] ?? 0;
                }

                if ($kriteria->jenis === 'benefit') {

                    $maxMin[$kriteria->id] = max($nilaiKriteria);
                } else {

                    $maxMin[$kriteria->id] = min($nilaiKriteria);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Normalisasi
            |--------------------------------------------------------------------------
            */
            $normalisasi = [];

            foreach ($matrix as $karyawanId => $nilaiKriteria) {

                foreach ($nilaiKriteria as $kriteriaId => $nilai) {

                    $kriteria = $kriterias
                        ->where('id', $kriteriaId)
                        ->first();

                    if ($kriteria->jenis === 'benefit') {

                        $normalisasi[$karyawanId][$kriteriaId]
                            = $nilai / $maxMin[$kriteriaId];
                    } else {

                        $normalisasi[$karyawanId][$kriteriaId]
                            = $maxMin[$kriteriaId] / $nilai;
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Hitung Nilai Akhir (V)
            |--------------------------------------------------------------------------
            */
            $hasilAkhir = [];

            foreach ($normalisasi as $karyawanId => $nilaiKriteria) {

                $total = 0;

                foreach ($nilaiKriteria as $kriteriaId => $nilaiNormalisasi) {

                    $kriteria = $kriterias
                        ->where('id', $kriteriaId)
                        ->first();

                    $total += (
                        $nilaiNormalisasi *
                        $kriteria->bobot
                    );
                }

                $hasilAkhir[$karyawanId] = $total;
            }

            /*
            |--------------------------------------------------------------------------
            | Ranking
            |--------------------------------------------------------------------------
            */
            arsort($hasilAkhir);

            /*
            |--------------------------------------------------------------------------
            | Hapus Hasil Lama
            |--------------------------------------------------------------------------
            */
            HasilSaw::where(
                'penilaian_id',
                $penilaian->id
            )->delete();

            /*
            |--------------------------------------------------------------------------
            | Simpan Hasil
            |--------------------------------------------------------------------------
            */
            $ranking = 1;

            foreach ($hasilAkhir as $karyawanId => $nilaiAkhir) {

                HasilSaw::create([
                    'penilaian_id' => $penilaian->id,
                    'karyawan_id'  => $karyawanId,
                    'nilai_akhir'  => round($nilaiAkhir, 4),
                    'ranking'      => $ranking,
                    'status_bonus' => 'belum_dihitung',
                    'nominal_bonus' => 0,
                ]);

                $ranking++;
            }
        });
    }
}
