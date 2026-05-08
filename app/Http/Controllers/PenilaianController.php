<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\DetailPenilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * 📌 Tampilkan semua penilaian
     */
    public function index()
    {
        $penilaians = Penilaian::with('user')
            ->latest()
            ->get();

        return view('pages.penilaian.index', compact('penilaians'));
    }

    /**
     * 📌 Form input penilaian
     */
    public function create()
    {
        $karyawans = Karyawan::where('status', 'aktif')
            ->get();

        $kriterias = Kriteria::all();

        return view('pages.penilaian.create', compact(
            'karyawans',
            'kriterias'
        ));
    }

    /**
     * 📌 Simpan penilaian + detail nilai
     */
    public function store(Request $request)
    {
        /**
         * =========================
         * VALIDASI
         * =========================
         */
        $request->validate([
            'periode' => 'required|string|max:255',
            'nilai'   => 'required|array',
        ]);

        /**
         * =========================
         * SIMPAN PENILAIAN
         * =========================
         */
        $penilaian = Penilaian::create([
            'user_id'            => auth()->id(),
            'periode'            => $request->periode,
            'tanggal_penilaian'  => now(),
        ]);

        /**
         * =========================
         * SIMPAN DETAIL NILAI
         * =========================
         */
        foreach ($request->nilai as $karyawan_id => $nilaiKriteria) {

            foreach ($nilaiKriteria as $kriteria_id => $nilai) {

                DetailPenilaian::create([
                    'penilaian_id' => $penilaian->id,
                    'karyawan_id'  => $karyawan_id,
                    'kriteria_id'  => $kriteria_id,
                    'nilai'        => $nilai,
                ]);
            }
        }

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    /**
     * 📌 Detail penilaian
     */
    public function show($id)
    {
        $penilaian = Penilaian::with([
            'user',
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria'
        ])->findOrFail($id);

        return view('pages.penilaian.detail', compact('penilaian'));
    }

    /**
     * 📌 Hapus penilaian
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);

        $penilaian->delete();

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }
}