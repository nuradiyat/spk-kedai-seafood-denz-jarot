<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * =====================================
     * LIST KARYAWAN + SEARCH
     * =====================================
     */
    public function index(Request $request)
    {
        $keywordSearch = $request->search;

        $karyawans = Karyawan::query()
            ->when($keywordSearch, function ($query) use ($keywordSearch) {
                $query->search($keywordSearch);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.karyawan.index', compact(
            'karyawans',
            'keywordSearch'
        ));
    }

    /**
     * =====================================
     * FORM CREATE
     * =====================================
     */
    public function create()
    {
        return view('pages.karyawan.create');
    }

    /**
     * =====================================
     * STORE
     * =====================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jabatan'       => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        Karyawan::create($validated);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    /**
     * =====================================
     * SHOW
     * =====================================
     */
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return view('pages.karyawan.show', compact('karyawan'));
    }

    /**
     * =====================================
     * EDIT
     * =====================================
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return view('pages.karyawan.edit', compact('karyawan'));
    }

    /**
     * =====================================
     * UPDATE
     * =====================================
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jabatan'       => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $karyawan->update($validated);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * =====================================
     * DELETE
     * =====================================
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }
}