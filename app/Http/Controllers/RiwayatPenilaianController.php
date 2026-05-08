<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\HasilSaw;

class RiwayatPenilaianController extends Controller
{
    /**
     * 📌 Tampilkan seluruh riwayat penilaian
     */
    public function index()
    {
        $penilaians = Penilaian::with([
            'user',
            'hasilSaws'
        ])
            ->latest()
            ->get();

        return view('pages.riwayat.index', compact('penilaians'));
    }

    /**
     * 📌 Detail riwayat penilaian
     */
    public function detail($id)
    {
        $penilaian = Penilaian::with([
            'user',
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria',
            'hasilSaws.karyawan'
        ])->findOrFail($id);

        return view('pages.riwayat.detail', compact('penilaian'));
    }

    /**
     * 📌 Hapus riwayat penilaian
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);

        $penilaian->delete();

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Riwayat penilaian berhasil dihapus');
    }

    /**
     * 📌 Export laporan
     */
    public function export($id)
    {
        $penilaian = Penilaian::with([
            'hasilSaws.karyawan'
        ])->findOrFail($id);

        return view('pages.riwayat.export', compact('penilaian'));
    }
}