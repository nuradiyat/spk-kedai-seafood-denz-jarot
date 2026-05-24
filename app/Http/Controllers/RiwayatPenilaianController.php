<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;

class RiwayatPenilaianController extends Controller
{
    /**
     * =========================================
     * LIST RIWAYAT PENILAIAN
     * =========================================
     */
    public function index()
    {
        $riwayat = Penilaian::with([
            'user',
            'hasilSaws'
        ])
            ->latest()
            ->get();

        return view('pages.riwayat.index', compact('riwayat'));
    }

    /**
     * =========================================
     * DETAIL RIWAYAT + HASIL SAW FINAL
     * =========================================
     */
    public function show($id)
    {
        $penilaian = Penilaian::with([
            'user',
            'hasilSaws.karyawan',
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria'
        ])->findOrFail($id);

        return view('pages.riwayat.show', compact('penilaian'));
    }

    /**
     * =========================================
     * EXPORT LAPORAN
     * =========================================
     */
    public function export($id)
    {
        $penilaian = Penilaian::with([
            'user',
            'hasilSaws.karyawan',
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria'
        ])->findOrFail($id);

        /**
         * NOTE:
         * idealnya nanti diganti:
         * - Laravel Excel
         * - atau DomPDF
         */
        return view('pages.riwayat.export', compact('penilaian'));
    }

    /**
     * =========================================
     * HAPUS RIWAYAT PENILAIAN
     * =========================================
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);

        /**
         * Hapus semua relasi terkait
         */
        $penilaian->hasilSaws()->delete();
        $penilaian->detailPenilaians()->delete();
        $penilaian->delete();

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Riwayat berhasil dihapus');
    }
}
