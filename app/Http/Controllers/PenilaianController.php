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
        $penilaians = Penilaian::all();

        return view('penilaian.index', compact('penilaians'));
    }

    /**
     * 📌 Form input penilaian
     */
    public function create()
    {
        $karyawans = Karyawan::all();
        $kriterias = Kriteria::all();

        return view('penilaian.create', compact('karyawans', 'kriterias'));
    }

    /**
     * 📌 Simpan penilaian + detail nilai
     */
    public function store(Request $request)
    {
        // 1️⃣ Simpan data penilaian (periode)
        $penilaian = Penilaian::create([
            'id_user' => auth()->user()->id, // Ambil ID user yang sedang login dari session
            'periode' => $request->periode, // Ambil periode dari form input
            'tanggal_penilaian' => now()
        ]);

        // 2️⃣ Simpan nilai tiap karyawan per kriteria
        foreach ($request->nilai as $id_karyawan => $nilaiKriteria) {

            foreach ($nilaiKriteria as $id_kriteria => $nilai) {

                DetailPenilaian::create([
                    'id_penilaian' => $penilaian->id,
                    'id_karyawan' => $id_karyawan,
                    'id_kriteria' => $id_kriteria,
                    'nilai' => $nilai
                ]);
            }
        }

        return redirect()->route('penilaian.index');
    }
}
