<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilSaw;
use App\Services\SAWService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HitungSaw extends Controller
{

    /**
     * 📌 Tampilkan form edit penilaian & persiapkan aksi perhitungan
     * 
     * Status penilaian yang dihandle:
     * - 'belum_diproses' => Tampilkan tombol "Hitung Saw" (perhitungan pertama kali)
     * - 'sudah_diproses' => Sudah ada hasil perhitungan (sebelumnya), jika ada edit data -> status jadi 'hitung_ulang_saw'
     * - 'hitung_ulang_saw' => Tampilkan tombol "Hitung Ulang Saw" (ada data yang di-edit)
     */
    public function show($id)
    {

        $penilaian = Penilaian::with([
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria'
        ])->findOrFail($id);

        // Ambil semua ID karyawan yang sudah dinilai pada periode ini,
        // lalu hapus ID yang duplikat agar setiap karyawan hanya muncul sekali.
        $karyawanIds = $penilaian->detailPenilaians
            ->pluck('karyawan_id')
            // unique() digunakan untuk menghapus duplikat ID karyawan, karena satu karyawan bisa memiliki banyak DetailPenilaian jika dinilai berdasarkan beberapa kriteria. Dengan unique(), kita memastikan bahwa setiap ID karyawan hanya muncul sekali dalam daftar.
            ->unique();

        $karyawans = Karyawan::whereIn('id', $karyawanIds)
            ->get();

        $kriterias = Kriteria::all();

        $nilaiLama = $penilaian->detailPenilaians
            ->groupBy('karyawan_id')
            ->map(function ($details) {
                return $details
                    ->pluck('nilai', 'kriteria_id')
                    ->toArray();
            })
            ->toArray();

        /**
         * Tentukan form action berdasarkan status perhitungan
         * 
         * Match expression untuk menentukan route yang akan di-submit:
         * - 'belum_diproses' => form akan di-submit ke hitungsaw.proses (jalankan perhitungan pertama kali)
         * - 'hitung_ulang_saw' => form akan di-submit ke hitungsaw.hitung-ulang (ulang perhitungan ada update data)
         * - default => fallback ke route proses
         */
        $formAction = match ($penilaian->status_perhitungan) {
            'belum_diproses' => route('hitungsaw.proses', $penilaian->id),
            'hitung_ulang_saw' => route('hitungsaw.hitung-ulang', $penilaian->id),
            default => route('hitungsaw.proses', $penilaian->id),
        };

        return view('pages.penilaian.hitungsaw', compact(
            'penilaian',
            'karyawans',
            'kriterias',
            'nilaiLama',
            'formAction'
        ));
    }

    /**
     * 📌 Jalankan perhitungan SAW pertama kali
     * 
     * Metod ini dijalankan ketika status_perhitungan = 'belum_diproses'
     * - Menjalankan SAWService::hitung() untuk menghitung nilai akhir setiap karyawan
     * - Membagikan bonus ke karyawan yang layak berdasarkan ranking
     * - Update status_perhitungan menjadi 'sudah_diproses'
     * - Redirect ke halaman hasil perhitungan
     */
    public function prosesPenilaian($id, SAWService $sawService)
    {
        $penilaian = Penilaian::findOrFail($id);

        // 1️⃣ Jalankan perhitungan SAW
        $sawService->hitung($penilaian);

        // 2️⃣ Bagikan bonus ke karyawan yang layak
        $this->bagikanBonus($penilaian);

        // 3️⃣ Update status perhitungan
        $penilaian->update([
            'status_perhitungan' => 'sudah_diproses'
        ]);

        return redirect()
            ->route('hasil.proses', $penilaian->id)
            ->with(
                'success',
                'Perhitungan SAW berhasil dijalankan'
            );
    }


    /**
     * 📌 Jalankan ulang perhitungan SAW (ketika ada update data)
     * 
     * Metod ini dijalankan ketika status_perhitungan = 'hitung_ulang_saw'
     * (biasanya dipicu ketika ada perubahan data nilai penilaian)
     * - Menjalankan SAWService::hitung() lagi dengan data terbaru
     * - Membagikan bonus ulang ke karyawan yang layak
     * - Update status_perhitungan kembali ke 'sudah_diproses'
     * - Redirect ke halaman hasil perhitungan yang sudah di-update
     */
    public function prosesUlangPenilaian($id, SAWService $sawService)
    {
        $penilaian = Penilaian::findOrFail($id);

        // 1️⃣ Jalankan perhitungan SAW ulang
        $sawService->hitung($penilaian);

        // 2️⃣ Bagikan bonus ke karyawan yang layak
        $this->bagikanBonus($penilaian);

        // 3️⃣ Update status perhitungan
        $penilaian->update([
            'status_perhitungan' => 'sudah_diproses'
        ]);

        return redirect()
            ->route('hasil.proses', $penilaian->id)
            ->with(
                'success',
                'Perhitungan SAW berhasil diperbarui'
            );
    }

    /**
     * 📌 Bagikan bonus ke karyawan yang layak berdasarkan hasil SAW
     * 
     * KRITERIA KELAYAKAN:
     * - Hanya karyawan dengan ranking 1, 2, 3 yang layak dapat bonus
     * - Bonus dibagikan secara proposional berdasarkan nilai akhir SAW
     * - Hanya karyawan layak yang mendapat bonus, yang lain status 'tidak_layak'
     * 
     * @param Penilaian $penilaian
     * @return void
     */
    private function bagikanBonus(Penilaian $penilaian): void
    {
        // 1️⃣ Ambil total bonus untuk periode ini
        $bonus = $penilaian->bonus;
        if (!$bonus || $bonus->total_bonus <= 0) {
            $this->markAllAsNotEligible($penilaian);
            return;
        }

        // 2️⃣ Ambil hasil SAW yang sudah dihitung
        $hasilSaw = HasilSaw::where('penilaian_id', $penilaian->id)
            ->orderBy('ranking')
            ->get();

        if ($hasilSaw->isEmpty()) {
            return;
        }

        // 3️⃣ Tentukan karyawan yang layak (ranking 1-3)
        $karyawanLayak = $hasilSaw->filter(function ($hasil) {
            return $hasil->ranking <= 3;
        });

        // 4️⃣ Hitung total nilai akhir karyawan yang layak (untuk proportional)
        $totalNilaiLayak = $karyawanLayak->sum('nilai_akhir');

        if ($totalNilaiLayak <= 0) {
            $this->markAllAsNotEligible($penilaian);
            return;
        }

        // 5️⃣ Bagikan bonus secara proporsi berdasarkan nilai akhir
        foreach ($hasilSaw as $hasil) {
            if ($hasil->ranking <= 3) {
                // Karyawan layak: bagikan bonus secara proporsi
                $nominalBonus = ($hasil->nilai_akhir / $totalNilaiLayak) * $bonus->total_bonus;
                
                $hasil->update([
                    'status_bonus' => 'layak',
                    'nominal_bonus' => round($nominalBonus, 2),
                ]);
            } else {
                // Karyawan tidak layak: tidak dapat bonus
                $hasil->update([
                    'status_bonus' => 'tidak_layak',
                    'nominal_bonus' => 0,
                ]);
            }
        }

        // 6️⃣ Update status bonus di table bonus
        $bonus->update([
            'status_bonus' => 'selesai'
        ]);
    }

    /**
     * 📌 Tandai semua karyawan sebagai tidak layak bonus
     * 
     * Digunakan ketika tidak ada bonus atau total bonus 0
     * 
     * @param Penilaian $penilaian
     * @return void
     */
    private function markAllAsNotEligible(Penilaian $penilaian): void
    {
        HasilSaw::where('penilaian_id', $penilaian->id)
            ->update([
                'status_bonus' => 'tidak_layak',
                'nominal_bonus' => 0,
            ]);
    }
}
