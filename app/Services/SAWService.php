<?php

namespace App\Services;

use App\Models\Penilaian;
use App\Models\Kriteria;
use App\Models\HasilSaw;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * ================================================================
 * SAW Service (Simple Additive Weighting)
 * ================================================================
 * 
 * Menjalankan proses perhitungan SAW untuk menentukan peringkat
 * karyawan berdasarkan kriteria penilaian yang telah ditentukan.
 * 
 * FLOW PROSES:
 * 1. Persiapkan data kriteria dan detail penilaian
 * 2. Bentuk matriks keputusan (nilai karyawan per kriteria)
 * 3. Cari nilai max (benefit) / min (cost) setiap kriteria
 * 4. Normalisasi nilai ke range 0-1
 * 5. Hitung nilai akhir (V) dengan pembobotan
 * 6. Tentukan ranking berdasarkan nilai akhir
 * 7. Simpan hasil ke database
 * ================================================================
 */
class SAWService
{
    /**
     * 📌 Jalankan proses perhitungan SAW lengkap
     * 
     * @param Penilaian $penilaian Data penilaian yang akan diproses
     * @return void
     */
    public function hitung(Penilaian $penilaian): void
    {
        DB::transaction(function () use ($penilaian) {
            
            // 1️⃣ Persiapkan data kriteria dan detail penilaian
            $kriterias = $this->getKriterias();
            $details = $this->getDetailPenilaian($penilaian);

            // 2️⃣ Bentuk matriks keputusan
            $matrix = $this->buatMatriksKeputusan($details);

            // 3️⃣ Cari nilai max/min setiap kriteria
            $maxMin = $this->cariMaxMin($matrix, $kriterias);

            // 4️⃣ Normalisasi nilai
            $normalisasi = $this->normalisasiNilai($matrix, $kriterias, $maxMin);

            // 5️⃣ Hitung nilai akhir (V)
            $hasilAkhir = $this->hitungNilaiAkhir($normalisasi, $kriterias);

            // 6️⃣ Tentukan ranking
            $hasilRanking = $this->tentukanRanking($hasilAkhir);

            // 7️⃣ Simpan hasil ke database
            $this->simpanHasil($penilaian, $hasilRanking);
        });
    }

    /**
     * 📌 Ambil semua kriteria dari database
     * 
     * @return Collection
     */
    private function getKriterias(): Collection
    {
        return Kriteria::all();
    }

    /**
     * 📌 Ambil detail penilaian dengan relasi karyawan dan kriteria
     * 
     * @param Penilaian $penilaian
     * @return Collection
     */
    private function getDetailPenilaian(Penilaian $penilaian): Collection
    {
        return $penilaian->detailPenilaians()
            ->with(['karyawan', 'kriteria'])
            ->get();
    }

    /**
     * 📌 Bentuk matriks keputusan dari detail penilaian
     * 
     * Format: 
     * [
     *     karyawan_id => [
     *         kriteria_id => nilai,
     *         kriteria_id => nilai,
     *     ]
     * ]
     * 
     * @param Collection $details
     * @return array
     */
    private function buatMatriksKeputusan(Collection $details): array
    {
        $matrix = [];

        foreach ($details as $detail) {
            $matrix[$detail->karyawan_id][$detail->kriteria_id] = $detail->nilai;
        }

        return $matrix;
    }

    /**
     * 📌 Cari nilai maksimum (benefit) atau minimum (cost) setiap kriteria
     * 
     * Benefit: Semakin tinggi nilai semakin baik (cari max)
     * Cost: Semakin rendah nilai semakin baik (cari min)
     * 
     * @param array $matrix
     * @param Collection $kriterias
     * @return array
     */
    private function cariMaxMin(array $matrix, Collection $kriterias): array
    {
        $maxMin = [];

        foreach ($kriterias as $kriteria) {
            
            // Kumpulkan semua nilai untuk kriteria ini
            $nilaiKriteria = [];
            foreach ($matrix as $nilaiPerKaryawan) {
                $nilaiKriteria[] = $nilaiPerKaryawan[$kriteria->id] ?? 0;
            }

            // Tentukan nilai referensi (max untuk benefit, min untuk cost)
            if ($kriteria->jenis === 'benefit') {
                $maxMin[$kriteria->id] = max($nilaiKriteria);
            } else {
                $maxMin[$kriteria->id] = min($nilaiKriteria);
            }
        }

        return $maxMin;
    }

    /**
     * 📌 Normalisasi nilai ke range 0-1
     * 
     * Formula Benefit: nilai_normal = nilai / nilai_max
     * Formula Cost: nilai_normal = nilai_min / nilai
     * 
     * @param array $matrix
     * @param Collection $kriterias
     * @param array $maxMin
     * @return array
     */
    private function normalisasiNilai(array $matrix, Collection $kriterias, array $maxMin): array
    {
        $normalisasi = [];

        foreach ($matrix as $karyawanId => $nilaiPerKriteria) {
            
            foreach ($nilaiPerKriteria as $kriteriaId => $nilai) {
                
                $kriteria = $kriterias->where('id', $kriteriaId)->first();

                if ($kriteria->jenis === 'benefit') {
                    // Semakin tinggi semakin baik
                    $normalisasi[$karyawanId][$kriteriaId] = $nilai / $maxMin[$kriteriaId];
                } else {
                    // Semakin rendah semakin baik
                    $normalisasi[$karyawanId][$kriteriaId] = $maxMin[$kriteriaId] / $nilai;
                }
            }
        }

        return $normalisasi;
    }

    /**
     * 📌 Hitung nilai akhir (V) dengan pembobotan
     * 
     * Formula: V = Σ (nilai_normalisasi × bobot_kriteria)
     * 
     * @param array $normalisasi
     * @param Collection $kriterias
     * @return array
     */
    private function hitungNilaiAkhir(array $normalisasi, Collection $kriterias): array
    {
        $hasilAkhir = [];

        foreach ($normalisasi as $karyawanId => $nilaiPerKriteria) {
            
            $totalNilaiAkhir = 0;

            foreach ($nilaiPerKriteria as $kriteriaId => $nilaiNormalisasi) {
                
                $kriteria = $kriterias->where('id', $kriteriaId)->first();
                
                // Kalikan nilai normalisasi dengan bobot kriteria
                $totalNilaiAkhir += ($nilaiNormalisasi * $kriteria->bobot);
            }

            $hasilAkhir[$karyawanId] = $totalNilaiAkhir;
        }

        return $hasilAkhir;
    }

    /**
     * 📌 Tentukan ranking berdasarkan nilai akhir (descending)
     * 
     * Ranking 1 = Nilai akhir tertinggi
     * 
     * @param array $hasilAkhir
     * @return array
     */
    private function tentukanRanking(array $hasilAkhir): array
    {
        // Sort descending (nilai tertinggi di depan)
        arsort($hasilAkhir);
        return $hasilAkhir;
    }

    /**
     * 📌 Simpan hasil perhitungan SAW ke database
     * 
     * - Hapus hasil lama terlebih dahulu
     * - Insert hasil baru dengan ranking dan status bonus
     * 
     * @param Penilaian $penilaian
     * @param array $hasilRanking
     * @return void
     */
    private function simpanHasil(Penilaian $penilaian, array $hasilRanking): void
    {
        // Hapus hasil SAW yang sudah ada
        HasilSaw::where('penilaian_id', $penilaian->id)->delete();

        // Simpan hasil SAW baru
        $ranking = 1;
        foreach ($hasilRanking as $karyawanId => $nilaiAkhir) {
            
            HasilSaw::create([
                'penilaian_id' => $penilaian->id,
                'karyawan_id' => $karyawanId,
                'nilai_akhir' => round($nilaiAkhir, 4),
                'ranking' => $ranking,
                'status_bonus' => 'belum_dihitung',
                'nominal_bonus' => 0,
            ]);

            $ranking++;
        }
    }
}
