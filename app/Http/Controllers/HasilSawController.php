<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HasilSaw;
use App\Models\Penilaian;
use App\Services\SAWService;
use Illuminate\Http\Request;

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
     * 📌 Tampilkan hasil ranking dengan opsi filter periode
     */
    public function index(Request $request)
    {
        $daftarPeriode = Penilaian::latest('tanggal_penilaian')->get();

        $periodeId = $request->query('periode');

        if ($periodeId) {
            $periode = Penilaian::find($periodeId);
        } else {
            $lastHasil = HasilSaw::latest()->first();
            $periode = $lastHasil ? Penilaian::find($lastHasil->penilaian_id) : $daftarPeriode->first();
        }

        if (!$periode) {
            $hasil = collect();
            $radarData = null;
        } else {
            $hasil = HasilSaw::with([
                'karyawan',
                'penilaian'
            ])
                ->where('penilaian_id', $periode->id)
                ->orderBy('ranking', 'asc')
                ->get();

            // Ambil data detail untuk Radar Chart
            $detailSaw = $this->saw->hitung($periode->id);
            $radarLabels = $detailSaw['kriterias']->map(fn ($c) => $c->kode . ' - ' . $c->nama_kriteria)->values();
            $palette = [
                ['border' => 'rgb(79, 70, 229)', 'bg' => 'rgba(79, 70, 229, 0.2)'],   // Indigo
                ['border' => 'rgb(16, 185, 129)', 'bg' => 'rgba(16, 185, 129, 0.2)'], // Emerald
                ['border' => 'rgb(245, 158, 11)', 'bg' => 'rgba(245, 158, 11, 0.2)'], // Amber
                ['border' => 'rgb(14, 165, 233)', 'bg' => 'rgba(14, 165, 233, 0.2)'], // Sky
                ['border' => 'rgb(244, 63, 94)', 'bg' => 'rgba(244, 63, 94, 0.2)'],   // Rose
            ];

            $radarDatasets = [];
            foreach ($hasil as $idx => $h) {
                $color = $palette[$idx % count($palette)];
                $dataPoints = [];
                foreach ($detailSaw['kriterias'] as $c) {
                    $norm = (float) ($detailSaw['normalisasi'][$h->karyawan_id][$c->id] ?? 0);
                    $dataPoints[] = round($norm, 3);
                }

                $radarDatasets[] = [
                    'label' => $h->karyawan->nama_karyawan ?? 'Karyawan',
                    'data' => $dataPoints,
                    'borderColor' => $color['border'],
                    'backgroundColor' => $color['bg'],
                    'borderWidth' => 2,
                    'pointBackgroundColor' => $color['border'],
                    'pointRadius' => 4,
                ];
            }

            $radarData = [
                'labels' => $radarLabels,
                'datasets' => $radarDatasets,
            ];
        }

        return view('pages.hasil.index', compact('hasil', 'periode', 'daftarPeriode', 'radarData'));
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
            ->route('hasil.index', ['periode' => $penilaian->id])
            ->with('success', 'Perhitungan SAW berhasil dilakukan');
    }

    /**
     * 📌 Detail proses SAW
     */
    public function detail($id)
    {
        $penilaian = Penilaian::findOrFail($id);
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
            $hasil = collect();
            $periode = null;
        } else {
            $periode = Penilaian::find($lastHasil->penilaian_id);
            $hasil = HasilSaw::with('karyawan')
                ->where('penilaian_id', $lastHasil->penilaian_id)
                ->orderBy('ranking', 'asc')
                ->get();
        }

        return view('pages.hasil.podium', compact('hasil', 'periode'));
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

    /**
     * 📌 Simulasi & Analisis Sensitivitas Bobot
     */
    public function sensitivitas($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $detailSaw = $this->saw->hitung($penilaian->id);

        return view('pages.hasil.sensitivitas', [
            'penilaian'      => $penilaian,
            'kriterias'      => $detailSaw['kriterias'],
            'karyawans'      => $detailSaw['karyawans'],
            'normalisasi'    => $detailSaw['normalisasi'],
            'rankingAwal'    => $detailSaw['ranking'],
            'nilaiAkhirAwal' => $detailSaw['nilai_akhir'],
        ]);
    }
}