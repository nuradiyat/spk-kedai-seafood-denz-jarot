<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HasilSaw;
use App\Models\Penilaian;
use App\Services\SAWService;

class HasilSawController extends Controller
{
    /**
     * 📌 Service SAW
     */
    protected $saw;

    /**
     * 📌 Dependency Injection
     */
    public function __construct(SAWService $saw)
    {
        $this->saw = $saw;
    }

    /**
     * 📌 Tampilkan hasil ranking
     */
    public function index()
    {
        $lastHasil = HasilSaw::latest()->first();

        if (!$lastHasil) {

            $hasils = collect();

        } else {

            $hasils = HasilSaw::with([
                'karyawan',
                'penilaian'
            ])
                ->where('penilaian_id', $lastHasil->penilaian_id)
                ->orderBy('ranking', 'asc')
                ->get();
        }

        return view('pages.hasil.index', compact('hasils'));
    }

    /**
     * 📌 Jalankan perhitungan SAW
     */
    public function proses($id)
    {
        /**
         * =========================
         * VALIDASI PENILAIAN
         * =========================
         */
        $penilaian = Penilaian::findOrFail($id);

        /**
         * =========================
         * HAPUS HASIL LAMA
         * =========================
         */
        HasilSaw::where('penilaian_id', $penilaian->id)
            ->delete();

        /**
         * =========================
         * HITUNG SAW
         * =========================
         */
        $this->saw->calculate($penilaian->id);

        return redirect()
            ->route('hasil.index')
            ->with('success', 'Perhitungan SAW berhasil dilakukan');
    }

    /**
     * 📌 Detail proses SAW
     */
    public function detail($id)
    {
        /**
         * =========================
         * VALIDASI PENILAIAN
         * =========================
         */
        $penilaian = Penilaian::findOrFail($id);

        /**
         * =========================
         * HITUNG DETAIL SAW
         * =========================
         */
        $hasil = $this->saw->hitung($penilaian->id);

        return view('pages.hasil.detail', compact(
            'hasil',
            'penilaian'
        ));
    }

    /**
     * 📌 Tampilan podium ranking
     */
    public function podium()
    {
        $lastHasil = HasilSaw::latest()->first();

        if (!$lastHasil) {

            $topRank = collect();

        } else {

            $topRank = HasilSaw::with('karyawan')
                ->where('penilaian_id', $lastHasil->penilaian_id)
                ->orderBy('ranking', 'asc')
                ->take(3)
                ->get();
        }

        return view('pages.hasil.podium', compact('topRank'));
    }

    /**
     * 📌 Hapus hasil SAW
     */
    public function destroy($id)
    {
        $hasil = HasilSaw::findOrFail($id);

        $hasil->delete();

        return redirect()
            ->back()
            ->with('success', 'Hasil SAW berhasil dihapus');
    }

    public function exportPdf($penilaianId)
    {
        $penilaian = Penilaian::findOrFail($penilaianId);

        $hasil = app(SAWService::class)
            ->hitung($penilaianId);

        $pdf = Pdf::loadView(
            'pages.hasil.export',
            compact('penilaian', 'hasil')
        );

        return $pdf->download(
            'hasil-saw-'.$penilaian->periode.'.pdf'
        );
    }
}