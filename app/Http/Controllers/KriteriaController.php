<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Tampilkan semua kriteria
     */
    public function index()
    {
        $kriterias = Kriteria::latest()->get();

        return view('pages.kriteria.index', compact('kriterias'));
    }

    /**
     * Form tambah
     */
    public function create()
    {
        return view('pages.kriteria.create');
    }

    /**
     * Simpan data
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
     * Form edit
     */
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        return view('pages.kriteria.edit', compact('kriteria'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $validated = $request->validate([
            'kode'          => 'required|string|max:10|unique:kriterias,kode,' . $id,
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric|min:0|max:1',
            'jenis'         => 'required|in:benefit,cost',
        ]);

        $kriteria->update($validated);

        return redirect()
            ->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diupdate');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $kriteria->delete();

        return redirect()
            ->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus');
    }
}