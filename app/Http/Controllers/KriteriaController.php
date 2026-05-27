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
        // ambil semua data kriteria dari database, lalu urutkan berdasarkan id terbaru
        $kriterias = Kriteria::latest()->get();

        // ambil varibabel $kriterias lalu jumlahkan semua 
        // lalu kalikan dengan 100 untuk mendapatkan total bobot dalam persen
        // yang tadi contoh 0.25 konversi menjadi 25%
        $totalBobot = $kriterias->sum('bobot') * 100;

        return view('pages.kriteria.index', compact('kriterias', 'totalBobot'));
    }

    /**
     * Form tambah
     */
    public function create()
    {
        // jumlah total bobot desimal
        $totalBobot = Kriteria::sum('bobot');

        // konversi sisa ke persen
        $sisaBobot = (1 - $totalBobot) * 100;

        return view('pages.kriteria.create', compact('sisaBobot'));
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
            // bobot hanya boleh 0 sampai 1 (min:0|max:1')
            // contoh: 0.25, 0.50, 1
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
