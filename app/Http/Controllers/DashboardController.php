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

        $totalKriteria = Kriteria::count();

        $totalPenilaian = Penilaian::count();

        /**
         * =====================================
         * AMBIL HASIL SAW TERAKHIR
         * =====================================
         */
        $lastHasil = HasilSaw::latest()->first();

        /**
         * =====================================
         * JIKA BELUM ADA HASIL
         * =====================================
         */
        if (!$lastHasil) {

            $penerimaBonus = 0;

            $ranking = collect();

        } else {

            /**
             * =====================================
             * TOTAL PENERIMA BONUS
             * =====================================
             */
            $penerimaBonus = HasilSaw::where(
                    'penilaian_id',
                    $lastHasil->penilaian_id
                )
                ->where('status_bonus', 'Diterima')
                ->count();

            /**
             * =====================================
             * TOP RANKING KARYAWAN
             * =====================================
             */
            $ranking = HasilSaw::with('karyawan')
                ->where('penilaian_id', $lastHasil->penilaian_id)
                ->orderBy('ranking', 'asc')
                ->take(5)
                ->get();
        }

        return view('pages.dashboard.index', compact(
            'totalKaryawan',
            'totalKriteria',
            'totalPenilaian',
            'penerimaBonus',
            'ranking'
        ));
    }
}