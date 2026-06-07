<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // ambil data bonus dengan relasi penilaian untuk menampilkan periode dan status perhitungan saw
        // contoh implementasi: Bonus::with('penilaian')->latest()->paginate(10);
        // dibaca dengan bahasa manusia: ambil data bonus beserta data penilaian yang terkait, 
        // urutkan dari yang terbaru, lalu tampilkan 10 data per halaman kenapa tidak pakai witdh(['penilaian']) karena kita hanya butuh data penilaian untuk menampilkan periode dan status perhitungan saw, tidak perlu mengambil data detail penilaian yang banyak dan tidak diperlukan di halaman index bonus
        // apan aharus pakai (['penilaian']) karena kita butuh data kapan pakai ('penilaian') untuk menampilkan periode dan status perhitungan saw di halaman index bonus, kalau tidak pakai (['penilaian']) maka
        $bonuses = Bonus::with([
            'penilaian.detailPenilaians'
        ])
            ->latest()
            ->paginate(10);

        $bonuses->through(function ($bonus) {

            $bonus->periode_label = \Carbon\Carbon::parse(
                $bonus->penilaian->periode
            )->translatedFormat('F Y');

            // cek status perhitungan saw 'sudah_di_hitung', 'belum_di_hitung' atau 'hitung ulang saw'
            $bonus->status_perhitungan = $bonus->penilaian->status_perhitungan;

            $bonus->jumlah_karyawan = $bonus->penilaian
                ->detailPenilaians
                ->pluck('karyawan_id')
                ->unique()
                ->count();

            $bonus->tanggal_penilaian = \Carbon\Carbon::parse(
                $bonus->penilaian->tanggal_penilaian
            )->translatedFormat('d F Y');


            $bonus->waktu_penilaian = $bonus->penilaian->created_at->diffForHumans();

            return $bonus;
        });


        // status bonus untuk ditampilkan di view
        return view('pages.bonus.index', compact('bonuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bonus = Bonus::with('penilaian')
            ->where('penilaian_id', $request->penilaian_id)
            ->first();

        return view('pages.bonus.create', compact('bonus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'penilaian_id' => 'required|exists:penilaians,id',
            'karyawan_id'  => 'required|exists:karyawans,id',
            'jumlah_bonus' => 'required|numeric|min:0',
        ]);

        // simpan bonus
        $bonus = Bonus::create([
            'penilaian_id' => $validated['penilaian_id'],
            'karyawan_id'  => $validated['karyawan_id'],
            'jumlah_bonus' => $validated['jumlah_bonus'],
        ]);

        return redirect()
            ->route('bonus.index')
            ->with('success', 'Bonus berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bonus $bonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bonus $bonus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bonus $bonus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bonus $bonus)
    {
        //
    }
}
