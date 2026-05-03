<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * 📌 Menampilkan semua data karyawan
     */
    public function index()
    {
        $karyawans = Karyawan::latest()->get();

        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * 📌 Form tambah karyawan
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * 📌 Simpan data karyawan
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
     * 📌 Form edit karyawan
     */
    public function edit(Karyawan $karyawan) // ✅ Route Model Binding
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * 📌 Update data karyawan
     */
    public function update(Request $request, Karyawan $karyawan) // ✅ Binding
    {
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
     * 📌 Hapus data karyawan
     */
    public function destroy(Karyawan $karyawan) // ✅ Binding
    {
        // ⚠️ Optional: cek relasi biar tidak error FK
        if ($karyawan->detailPenilaian()->exists()) {
            return redirect()
                ->route('karyawan.index')
                ->with('error', 'Data tidak bisa dihapus karena sudah digunakan di penilaian');
        }

        $karyawan->delete();

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }
}
