<?php

namespace App\Http\Controllers;

use App\Models\HasilSaw;
use App\Services\SAWService;

class HasilSawController extends Controller
{
    protected $saw;

    // ✅ Dependency Injection
    public function __construct(SAWService $saw)
    {
        $this->saw = $saw;
    }

    /**
     * 📌 Jalankan perhitungan SAW & simpan ke database
     */
    public function proses($id_penilaian)
    {
        // ✅ pakai service dari DI
        $this->saw->calculate($id_penilaian);

        return back()->with('success', 'Perhitungan SAW berhasil');
    }

    /**
     * 📌 Tampilkan hasil ranking (dari database)
     */
    public function index()
    {
        $hasil = HasilSaw::with('karyawan')
            ->orderBy('ranking')
            ->get();

        return view('hasil.index', compact('hasil'));
    }

    /**
     * 📌 Detail perhitungan SAW (tidak dari DB, tapi dihitung ulang)
     */
    public function detail($id_penilaian)
    {
        $hasil = $this->saw->hitung($id_penilaian);

        return view('hasil.detail', compact('hasil'));
    }
}
