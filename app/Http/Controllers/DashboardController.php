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
        $totalKaryawan = Karyawan::count();

        $totalKriteria = Kriteria::count();

        $totalPenilaian = Penilaian::count();

        $penerimaBonus = HasilSaw::where('status_bonus', 'Diterima')
            ->count();

        $ranking = HasilSaw::with('karyawan')
            ->orderBy('ranking')
            ->get();

        return view('pages.dashboard.index', compact(
            'totalKaryawan',
            'totalKriteria',
            'totalPenilaian',
            'penerimaBonus',
            'ranking'
        ));
    }
}