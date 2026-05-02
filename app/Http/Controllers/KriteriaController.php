<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * 📌 Tampilkan semua kriteria
     */
    public function index()
    {
        $kriterias = Kriteria::all();

        return view('kriteria.index', compact('kriterias'));
    }

    /**
     * 📌 Simpan kriteria
     */
    public function store(Request $request)
    {
        Kriteria::create($request->all());

        return back();
    }

    /**
     * 📌 Update kriteria
     */
    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $kriteria->update($request->all());

        return back();
    }

    /**
     * 📌 Hapus kriteria
     */
    public function destroy($id)
    {
        Kriteria::findOrFail($id)->delete();

        return back();
    }
}
