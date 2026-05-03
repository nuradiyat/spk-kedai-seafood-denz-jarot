<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * 📌 Tampilkan semua kriteria
     */
    public function index()
    {
        $kriterias = Kriteria::latest()->get();

        return view('kriteria.index', compact('kriterias'));
    }

    /**
     * 📌 Form tambah kriteria
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * 📌 Simpan kriteria
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'          => 'required|string|max:10|unique:kriterias,kode',
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric|min:0|max:1',
            'jenis'         => 'required|in:benefit,cost',
        ]);

        Kriteria::create($validated);

        return redirect()
            ->route('kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }

    /**
     * 📌 Form edit kriteria
     */
    public function edit(Kriteria $kriteria) // ✅ Route Model Binding
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    /**
     * 📌 Update kriteria
     */
    public function update(Request $request, Kriteria $kriteria) // ✅ Binding
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:kriterias,kode,' . $kriteria->id,
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'jenis' => 'required|in:benefit,cost',
        ]);

        $kriteria->update($validated);

        return redirect()
            ->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diupdate');
    }

    /**
     * 📌 Hapus kriteria
     */
    public function destroy(Kriteria $kriteria) // ✅ Binding
    {
        // ⚠️ Cegah error jika dipakai di penilaian
        if ($kriteria->detailPenilaian()->exists()) {
            return redirect()
                ->route('kriteria.index')
                ->with('error', 'Kriteria tidak bisa dihapus karena sudah digunakan');
        }

        $kriteria->delete();

        return redirect()
            ->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus');
    }
}
