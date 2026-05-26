<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Tampilkan semua karyawan
     */
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // 🔍 SEARCH LOGIC
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_karyawan', 'like', '%' . $request->search . '%')
                    ->orWhere('jabatan', 'like', '%' . $request->search . '%')
                    ->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }

        $karyawans = $query->latest()->paginate(10);

        return view('pages.karyawan.index', compact('karyawans'));
    }

    /**
     * Form tambah
     */
    public function create()
    {
        return view('pages.karyawan.create');
    }

    /**
     * Simpan data
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
     * Detail karyawan
     */
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return view('pages.karyawan.show', compact('karyawan'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return view('pages.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update data
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
            ->with('success', 'Data karyawan berhasil diupdate');
    }

    /**
     * Hapus data
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
