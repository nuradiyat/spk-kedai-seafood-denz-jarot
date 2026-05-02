<?php

namespace App\Http\Controllers;

use App\Models\HasilSaw;
use App\Services\SAWService;

class HasilSawController extends Controller
{
    /**
     * 📌 Jalankan perhitungan SAW
     */
    public function proses($id_penilaian)
    {
        // Panggil service SAW
        $saw = new SAWService();
        $saw->calculate($id_penilaian);

        return back()->with('success', 'Perhitungan SAW berhasil');
    }

    /**
     * 📌 Tampilkan hasil ranking
     */
    public function index()
    {
        $hasil = HasilSaw::with('karyawan')
            ->orderBy('ranking')
            ->get();

        return view('hasil.index', compact('hasil'));
    }
}
