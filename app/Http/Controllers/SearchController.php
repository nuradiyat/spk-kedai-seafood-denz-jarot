<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaian;

class SearchController extends Controller
{
    /**
     * Tampilkan hasil pencarian terpadu untuk Karyawan, Kriteria, dan Periode Penilaian
     */
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', $request->input('search', '')));

        $karyawans = collect();
        $kriterias = collect();
        $penilaians = collect();

        if ($query !== '') {
            $karyawans = Karyawan::where(function ($q) use ($query) {
                $q->where('nama_karyawan', 'LIKE', "%{$query}%")
                  ->orWhere('jabatan', 'LIKE', "%{$query}%");
            })->get();

            $kriterias = Kriteria::where(function ($q) use ($query) {
                $q->where('kode', 'LIKE', "%{$query}%")
                  ->orWhere('nama_kriteria', 'LIKE', "%{$query}%");
            })->orderBy('kode', 'asc')->get();

            $penilaians = Penilaian::with(['user', 'hasilSaws'])
                ->where('periode', 'LIKE', "%{$query}%")
                ->latest()
                ->get();
        }

        $totalResults = $karyawans->count() + $kriterias->count() + $penilaians->count();

        return view('pages.search.index', compact('query', 'karyawans', 'kriterias', 'penilaians', 'totalResults'));
    }
}
