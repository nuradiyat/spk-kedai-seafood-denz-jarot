<?php

namespace App\Http\Controllers;

use App\Models\HasilSaw;
use App\Models\Penilaian;
use App\Services\SAWService;

class HasilSawController extends Controller
{
    protected $saw;

    /**
     * 📌 Dependency Injection
     */
    public function __construct(SAWService $saw)
    {
        $this->saw = $saw;
    }

    /**
     * 📌 Jalankan perhitungan SAW & simpan ke database
     */
    public function proses($penilaian_id)
    {
        // ✅ Pastikan penilaian ada
        $penilaian = Penilaian::findOrFail($penilaian_id);

        // ✅ Jalankan SAW (gunakan ID langsung)
        $this->saw->calculate($penilaian->id);

        return redirect()
            ->back()
            ->with('success', 'Perhitungan SAW berhasil dilakukan');
    }

    /**
     * 📌 Tampilkan hasil ranking (dari database)
     */
    public function index()
    {
        $hasil = HasilSaw::with(['karyawan', 'penilaian'])
            ->orderBy('ranking', 'asc')
            ->get();

        return view('hasil.index', compact('hasil'));
    }

    /**
     * 📌 Detail perhitungan SAW (REALTIME, tidak dari DB)
     */
    public function detail($penilaian_id)
    {
        // ✅ Validasi penilaian
        $penilaian = Penilaian::findOrFail($penilaian_id);

        // ✅ Hitung SAW tanpa simpan
        $hasil = $this->saw->hitung($penilaian->id);

        return view('hasil.detail', compact('hasil', 'penilaian'));
    }
}
