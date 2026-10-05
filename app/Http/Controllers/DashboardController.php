<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penilaian;
use App\Models\HasilSaw;
use App\Models\Kriteria;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * =====================================
         * TOTAL DATA
         * =====================================
         */
        $totalKaryawan = Karyawan::count();
        $karyawanAktif = Karyawan::where('status', 'aktif')->count();
        $totalKriteria = Kriteria::count();
        $totalPenilaian = Penilaian::count();
        $kriteria = Kriteria::all();

        /**
         * Penilaian terbaru (5 terakhir) + jumlah hasil
         */
        $penilaianTerbaru = Penilaian::with(['user', 'hasilSaws'])
            ->latest('tanggal_penilaian')
            ->take(5)
            ->get();

        /**
         * =====================================
         * AMBIL HASIL SAW TERAKHIR
         * =====================================
         */
        $lastHasil = HasilSaw::latest()->first();

        if (!$lastHasil) {
            $penerimaBonus = 0;
            $topRanking = collect();
        } else {
            $topRanking = HasilSaw::with('karyawan')
                ->where('penilaian_id', $lastHasil->penilaian_id)
                ->orderBy('ranking', 'asc')
                ->get();

            $penerimaBonus = $topRanking->where('status_bonus', 'Diterima')->count();
        }

        return view('pages.dashboard.index', compact(
            'totalKaryawan',
            'karyawanAktif',
            'totalKriteria',
            'totalPenilaian',
            'penerimaBonus',
            'kriteria',
            'penilaianTerbaru',
            'topRanking'
        ));
    }
}