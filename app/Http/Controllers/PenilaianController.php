<?php

namespace App\Http\Controllers;

use App\Services\SAWService;
use App\Models\Penilaian;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\DetailPenilaian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    /**
     * 📌 Tampilkan semua penilaian
     */
    public function index()
    {
        $penilaians = Penilaian::with([
            'user',
            'detailPenilaians',
            'bonus'
        ])
            ->latest()
            ->paginate(10);

        $penilaians->through(function ($penilaian) {

            $penilaian->periode_label =
                Carbon::parse($penilaian->periode)
                ->translatedFormat('F Y');

            $penilaian->is_processed =
                $penilaian->status_perhitungan === 'sudah_diproses';

            $penilaian->jumlah_karyawan =
                $penilaian->detailPenilaians
                ->pluck('karyawan_id')
                ->unique()
                ->count();

            return $penilaian;
        });

        return view(
            'pages.penilaian.index', compact('penilaians')
        );
    }

    /**
     * 📌 Form input penilaian
     */
    public function create()
    {
        // Hanya ambil karyawan yang statusnya aktif
        $karyawans = Karyawan::where('status', 'aktif')
            ->get();

        $kriterias = Kriteria::all();

        // dd($karyawans->count(), $kriterias->count());
        return view('pages.penilaian.create', compact(
            'karyawans',
            'kriterias'
        ));
    }

    /**
     * 📌 Simpan penilaian 
     */
    public function store(Request $request)
    {
        /**
         * =========================
         * VALIDASI
         * =========================
         */
        $request->validate([
            'periode' => 'required|string|max:255',
            'nilai'   => 'required|array',
            'nilai.*.*' => 'required|numeric|min:0',
        ]);

        /**
         * =========================
         * SIMPAN PENILAIAN
         * =========================
         */
        $penilaian = Penilaian::create([
            // TODO: Ganti dengan user yang sedang login
            'user_id'            => Auth::id(),
            'periode'            => $request->periode,
            'tanggal_penilaian'  => now(),
        ]);

        /**
         * =========================
         * SIMPAN DETAIL NILAI
         * =========================
         */
        foreach ($request->nilai as $karyawan_id => $nilaiKriteria) {

            foreach ($nilaiKriteria as $kriteria_id => $nilai) {

                DetailPenilaian::create([
                    'penilaian_id' => $penilaian->id,
                    'karyawan_id'  => $karyawan_id,
                    'kriteria_id'  => $kriteria_id,
                    'nilai'        => $nilai,
                ]);
            }
        }

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    /**
     * 📌 Detail penilaian 
     * menampilkan detail penilaian dan mejalankan hasil perhitungan
     * sesuai dengan status_perhitungan jika belum di proses tampilkan tombol jalakan perhitungan
     * jika status_perhitungan pendding atau sudah di proses jalakan ulang perhitungan
     */
    public function show($id)
    {
        $penilaian = Penilaian::with([
            'user',
            'detailPenilaians'
        ])->findOrFail($id);


        return view('pages.penilaian.show', compact('penilaian'));
    }

    /**
     * 📌 jalankan perhitungan saw
     * ini akan menghitung nilai akhir (V) untuk setiap karyawan berdasarkan metode SAW.
     * Setelah proses ini, status_perhitungan di update menjadi "sudah_dipros.
     * ini di jalakan hanya saat status saw "belum di Proses" maka tombol yang yang akan
     * di tampilkan hanya jalakan perhitungan saw
     */
    public function prosesPenilaian($id, SAWService $sawService)
    {
        $penilaian = Penilaian::findOrFail($id);

        $sawService->hitung($penilaian);

        $penilaian->update([
            'status_perhitungan' => 'sudah_diproses'
        ]);

        return redirect()
            ->route('hasil.proses', $penilaian->id)
            ->with(
                'success',
                'Perhitungan SAW berhasil dijalankan'
            );
    }


    /**
     * 📌 jalankan ulang perhitungan saw (update) 
     * karena ada data yang di edit, maka proses perhitungan saw hitung_ulang_saw harus dijalankan ulang untuk memperbarui 
     * nilai akhir (V) untuk setiap karyawan. setela di jalakan sekali lagi, maka status_perhitungan di update menjadi "sudah_diproses" lagi, 
     * karena proses perhitungan sudah selesai dijalankan ulang, saat status proses "sudah_diproses" 
     * tombol perhitungan tetap jalakan ulang perhitungan saw, jalakan perhitungan saw ada ketika
     * status saw "belum di proses
     */
    public function prosesUlangPenilaian($id, SAWService $sawService)
    {
        $penilaian = Penilaian::findOrFail($id);

        $sawService->hitung($penilaian);

        $penilaian->update([
            'status_perhitungan' => 'sudah_diproses'
        ]);

        return redirect()
            ->route('hasil.proses', $penilaian->id)
            ->with(
                'success',
                'Perhitungan SAW berhasil diperbarui'
            );
    }

    /**
     * 📌 Form edit penilaian
     * akan mengubah data penilaian karyawan, karena ada data yang di rubah
     * makan status_saw akan di update manjadi "pendding", maka harus
     * di jalakan ulang perhitungan di show setelah prosesUlangPenilaian akan di jalakan
     * makan status akan status_saw akan ter update kembali menjadi "sudah_diproses"
     */
    public function edit($id)
    {

        // Ambil data Penilaian berdasarkan ID yang dikirim.
        // Dari Penilaian tersebut, ambil semua DetailPenilaian
        // melalui method detailPenilaians() yang ada di model Penilaian.
        //
        // Dari setiap DetailPenilaian, ambil data Karyawan
        // melalui method karyawan() yang ada di model DetailPenilaian.
        //
        // Dari setiap DetailPenilaian, ambil data Kriteria
        // melalui method kriteria() yang ada di model DetailPenilaian.
        $penilaian = Penilaian::with([
            'detailPenilaians.karyawan',
            'detailPenilaians.kriteria'
        ])->findOrFail($id);

        // Ambil semua ID karyawan yang sudah dinilai pada periode ini,
        // lalu hapus ID yang duplikat agar setiap karyawan hanya muncul sekali.
        $karyawanIds = $penilaian->detailPenilaians
            ->pluck('karyawan_id')
            ->unique();

        $karyawans = Karyawan::whereIn('id', $karyawanIds)
            ->get();

        $kriterias = Kriteria::all();

        $nilaiLama = $penilaian->detailPenilaians
            ->groupBy('karyawan_id')
            ->map(function ($details) {
                return $details
                    ->pluck('nilai', 'kriteria_id')
                    ->toArray();
            })
            ->toArray();

        return view('pages.penilaian.edit', compact(
            'penilaian',
            'karyawans',
            'kriterias',
            'nilaiLama'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai'      => 'required|array',
            'nilai.*.*'  => 'required|integer|min:1|max:5',
        ]);

        $penilaian = Penilaian::findOrFail($id);

        foreach ($request->nilai as $karyawanId => $nilaiKriteria) {

            foreach ($nilaiKriteria as $kriteriaId => $nilai) {

                DetailPenilaian::where([
                    'penilaian_id' => $penilaian->id,
                    'karyawan_id' => $karyawanId,
                    'kriteria_id' => $kriteriaId,
                ])->update([
                    'nilai' => $nilai
                ]);
            }
        }

        $penilaian->update([
            'status_perhitungan' => 'hitung_ulang_saw'
        ]);

        // redirect penilaian show untuk jalakan proses saw
        return redirect()
            ->route('penilaian.show', $penilaian->id)
            ->with('success', 'Data berhasil diperbarui');
    }


    /**
     * 📌 Hapus penilaian
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);

        $penilaian->delete();

        return redirect()
            ->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }
}
