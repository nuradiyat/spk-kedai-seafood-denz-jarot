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
         * STATISTIK UTAMA
         * =====================================
         */
        $totalKaryawan = Karyawan::count();
        $totalKriteria = Kriteria::count();
        $totalPenilaian = Penilaian::count();

        /**
         * =====================================
         * PENERIMA BONUS (VALID SAJA)
         * =====================================
         */
        $penerimaBonus = HasilSaw::where('status_bonus', 'Diterima')
            ->whereNotNull('ranking')
            ->count();

        /**
         * =====================================
         * TOP 3 RANKING
         * =====================================
         */
        $ranking = HasilSaw::with('karyawan')
            ->whereNotNull('ranking')
            ->orderBy('ranking', 'asc')
            ->limit(3)
            ->get();

        /**
         * =====================================
         * RETURN VIEW
         * =====================================
         */
        return view('pages.dashboard.index', compact(
            'totalKaryawan',
            'totalKriteria',
            'totalPenilaian',
            'penerimaBonus',
            'ranking'
        ));
    }
}
