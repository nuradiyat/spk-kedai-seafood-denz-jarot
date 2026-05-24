<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\DetailPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    /**
     * =========================================
     * LIST PENILAIAN
     * =========================================
     */
    public function index()
    {
        $penilaians = Penilaian::with([
            'user',
            'detailPenilaians',
            'hasilSaws'
        ])
            ->latest()
            ->paginate(10);

        return view('pages.penilaian.index', compact('penilaians'));
    }

    /**
     * =========================================
     * FORM CREATE
     * =========================================
     */
    public function create()
    {
        $karyawans = Karyawan::where('status', 'aktif')->get();
        $kriterias = Kriteria::all();

        return view('pages.penilaian.create', compact(
            'karyawans',
            'kriterias'
        ));
    }

    /**
     * =========================================
     * STORE PENILAIAN
     * =========================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'nilai'   => 'required|array',
        ]);

        $penilaian = Penilaian::create([
            'user_id' => Auth::id(),
            'periode' => $request->periode,
        ]);

        foreach ($request->nilai as $karyawanId => $kriteriaData) {
            foreach ($kriteriaData as $kriteriaId => $nilai) {
                DetailPenilaian::create([
                    'penilaian_id' => $penilaian->id,
                    'karyawan_id'  => $karyawanId,
                    'kriteria_id'  => $kriteriaId,
                    'nilai'        => $nilai,
                ]);
            }
        }

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    /**
     * =========================================
     * SHOW DETAIL INPUT
     * =========================================
     */
    public function show($id)
    {
        $penilaian = Penilaian::with([
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria',
            'hasilSaws'
        ])->findOrFail($id);

        // Ambil Data Karyawan & Kriteria untuk Tabel Detail
        $karyawans = Karyawan::where('status', 'aktif')->get();

        $kriterias = Kriteria::all();

        // Build Matrix Nilai
        $nilaiMatrix = [];

        foreach ($penilaian->detailPenilaians as $detailPenilaian) {

            $nilaiMatrix[$detailPenilaian->karyawan_id][$detailPenilaian->kriteria_id]
                = $detailPenilaian->nilai;
        }

        return view('pages.penilaian.show', compact(
            'penilaian',
            'karyawans',
            'kriterias',
            'nilaiMatrix'
        ));
    }

    /**
     * =========================================
     * EDIT PENILAIAN
     * =========================================
     */
    public function edit($id)
    {
        $penilaian = Penilaian::with([
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria',
            'hasilSaws'
        ])->findOrFail($id);

        $karyawans = Karyawan::where('status', 'aktif')->get();
        $kriterias = Kriteria::all();

        // BUILD NILAI LAMA (IMPORTANT)
        $nilaiLama = [];

        foreach ($penilaian->detailPenilaians as $detail) {
            $nilaiLama[$detail->karyawan_id][$detail->kriteria_id] = $detail->nilai;
        }

        return view('pages.penilaian.edit', compact(
            'penilaian',
            'karyawans',
            'kriterias',
            'nilaiLama'
        ));
    }

    /**
     * =========================================
     * UPDATE PENILAIAN
     * =========================================
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'periode' => 'required|string',
            'nilai'   => 'required|array',
        ]);

        $penilaian = Penilaian::findOrFail($id);

        $penilaian->update([
            'periode' => $request->periode,
        ]);

        $penilaian->detailPenilaians()->delete();

        foreach ($request->nilai as $karyawanId => $kriteriaData) {
            foreach ($kriteriaData as $kriteriaId => $nilai) {
                DetailPenilaian::create([
                    'penilaian_id' => $penilaian->id,
                    'karyawan_id'  => $karyawanId,
                    'kriteria_id'  => $kriteriaId,
                    'nilai'        => $nilai,
                ]);
            }
        }

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * =========================================
     * DELETE PENILAIAN
     * =========================================
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);

        $penilaian->detailPenilaians()->delete();
        $penilaian->delete();

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }
}
