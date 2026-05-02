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
        // Ambil semua data karyawan dari database
        $karyawans = Karyawan::all();

        // Kirim ke view
        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * 📌 Menampilkan form tambah karyawan
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * 📌 Menyimpan data karyawan baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_karyawan' => 'required'
        ]);

        // Simpan ke database
        Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan
        ]);

        return redirect()->route('karyawan.index');
    }

    /**
     * 📌 Menampilkan form edit
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * 📌 Update data karyawan
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->update([
            'nama_karyawan' => $request->nama_karyawan
        ]);

        return redirect()->route('karyawan.index');
    }

    /**
     * 📌 Hapus data karyawan
     */
    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();

        return back();
    }
}
