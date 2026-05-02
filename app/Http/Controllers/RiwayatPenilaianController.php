<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPenilaian;

class RiwayatPenilaianController extends Controller
{
    /**
     * 📌 Tampilkan riwayat penilaian
     */
    public function index()
    {
        $riwayats = RiwayatPenilaian::all();

        return view('riwayat.index', compact('riwayats'));
    }
}
