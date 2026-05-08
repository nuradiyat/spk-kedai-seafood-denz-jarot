<?php

namespace App\Http\Controllers;

use App\Models\DetailPenilaian;
use App\Models\Penilaian;
use App\Models\Karyawan;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class DetailPenilaianController extends Controller
{
    /**
     * 📌 Tampilkan semua detail penilaian
     */
    public function index()
    {
        $details = DetailPenilaian::with([
            'penilaian',
            'karyawan',
            'kriteria'
        ])->latest()->get();

        return view('pages.penilaian.detail', compact('details'));
    }

    /**
     * 📌 Detail data penilaian
     */
    public function show($id)
    {
        $detail = DetailPenilaian::with([
            'penilaian',
            'karyawan',
            'kriteria'
        ])->findOrFail($id);

        return view('pages.penilaian.detail', compact('detail'));
    }

    /**
     * 📌 Form edit detail nilai
     */
    public function edit($id)
    {
        $detail = DetailPenilaian::findOrFail($id);

        $karyawans = Karyawan::all();

        $kriterias = Kriteria::all();

        return view('pages.penilaian.edit', compact(
            'detail',
            'karyawans',
            'kriterias'
        ));
    }

    /**
     * 📌 Update detail nilai
     */
    public function update(Request $request, $id)
    {
        $detail = DetailPenilaian::findOrFail($id);

        $validated = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $detail->update($validated);

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Detail penilaian berhasil diupdate');
    }

    /**
     * 📌 Hapus detail nilai
     */
    public function destroy($id)
    {
        $detail = DetailPenilaian::findOrFail($id);

        $detail->delete();

        return redirect()
            ->back()
            ->with('success', 'Detail penilaian berhasil dihapus');
    }
}