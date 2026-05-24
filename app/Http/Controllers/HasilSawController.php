<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\HasilSaw;
use App\Services\SAWService;

class HasilSawController extends Controller
{
    // ini dugunkan untuk meng-inject SAWService ke dalam controller, 
    // sehingga kita bisa menggunakan metode calculate() di dalamnya untuk menjalankan proses SAW.
    protected $sawService;

    // ini digunkan untuk menginisialisasi SAWService ketika controller ini dibuat. 
    // Dengan menggunakan dependency injection, kita memastikan bahwa controller ini memiliki 
    // akses ke semua metode yang disediakan oleh SAWService, terutama metode calculate() yang digunakan 
    //untuk menjalankan proses SAW pada penilaian tertentu.
    public function __construct(SAWService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * =========================================
     * HALAMAN HASIL SAW
     * =========================================
     */
    public function index()
    {
        /**
         * Ambil semua penilaian
         * (yang bisa diproses SAW)
         */
        $penilaians = Penilaian::with([
            'user',
            'detailPenilaians'
        ])->latest()->get();

        return view('pages.hasil.index', compact('penilaians'));
    }

    /**
     * =========================================
     * PROSES SAW
     * =========================================
     */
    public function proses($penilaianId)
    {
        /**
         * Jalankan SAW SERVICE
         * (SEMUA LOGIC ADA DI SERVICE)
         */
        $result = $this->sawService->calculate($penilaianId);

        return redirect()
            ->route('hasil.index')
            ->with('success', 'Perhitungan SAW berhasil dijalankan');
    }

    /**
     * =========================================
     * DETAIL HASIL SAW
     * =========================================
     */
    public function show($penilaianId)
    {
        $hasil = HasilSaw::with([
            'karyawan',
            'penilaian'
        ])
            ->where('penilaian_id', $penilaianId)
            ->orderBy('ranking')
            ->get();

        return view('pages.hasil.show', compact('hasil'));
    }

    /**
     * =========================================
     * HAPUS HASIL SAW
     * =========================================
     */
    public function destroy($id)
    {
        $hasil = HasilSaw::findOrFail($id);

        $hasil->delete();

        return redirect()
            ->back()
            ->with('success', 'Hasil SAW berhasil dihapus');
    }
}
