<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Carbon\Carbon;
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

            // cek status perhitungan saw 'sudah_di_hitung', 'belum_di_hitung' atau 'hitung ulang saw
            // dimabil dari tabel penilaian
            $bonus->status_perhitungan = $bonus->penilaian->status_perhitungan;

            // bisa pake di views blade pemanggilaan $bonus->jumlah_karyawan untuk menampilkan jumlah karyawan yang dinilai di periode tersebut, karena kita sudah mengambil data detail penilaian dengan with(['penilaian.detailPenilaians']) jadi kita bisa menghitung jumlah karyawan yang dinilai dengan mengambil data detail penilaian lalu pluck('karyawan_id') untuk mengambil id karyawan yang dinilai lalu unique() untuk menghilangkan duplikat id karyawan yang dinilai lalu count() untuk menghitung jumlah karyawan yang dinilai
            $bonus->jumlah_karyawan = $bonus->penilaian
                ->detailPenilaians
                ->pluck('karyawan_id')
                ->unique()
                ->count();

            $bonus->tanggal_dipenilaian = \Carbon\Carbon::parse(
                $bonus->penilaian->tanggal_penilaian
            )->translatedFormat('d F Y');

            // diffForHumans untuk menampilkan waktu yang sudah berlalu sejak tanggal penilaian dibuat, misalnya "2 hari yang lalu", "3 jam yang lalu", dll
            $bonus->waktu_penilaian = $bonus->penilaian->created_at->diffForHumans();


            $bonus->waktu_penilaian = $bonus->penilaian->created_at->diffForHumans();

            return $bonus;
        });

        // card
        $totalBonus = $bonuses->total();

        $bonusSudahDiisi = $bonuses
            ->getCollection()
            ->whereNotNull('total_bonus')
            ->count();

        $bonusBelumDiisi = $bonuses
            ->getCollection()
            ->whereNull('total_bonus')
            ->count();



        // status bonus untuk ditampilkan di view
        return view('pages.bonus.index', compact('bonuses', 'bonusSudahDiisi', 'bonusBelumDiisi', 'totalBonus'));
    }

    /**
     * menampilkan form create untuk meng update data bonus
     */
    public function create(Bonus $bonus)
    {
        // ambil relasi yang dibutuhkan
        $bonus->load('penilaian.detailPenilaians');

        // format periode
        $bonus->periode_label = Carbon::parse(
            $bonus->penilaian->periode
        )->translatedFormat('F Y');

        // format tanggal penilaian
        $bonus->tanggal_penilaian_label = Carbon::parse(
            $bonus->penilaian->tanggal_penilaian
        )->translatedFormat('d F Y');

        // status perhitungan SAW
        $bonus->status_perhitungan =
            $bonus->penilaian->status_perhitungan;

        // jumlah karyawan yang dinilai
        $bonus->jumlah_karyawan =
            $bonus->penilaian
            ->detailPenilaians
            ->pluck('karyawan_id')
            ->unique()
            ->count();

        // status bonus untuk ditampilkan di view
        $bonus->status_bonus =
            is_null($bonus->total_bonus)
            ? 'Belum Diberikan'
            : 'Sudah Diberikan';

        return view('pages.bonus.create',
            compact('bonus')
        );
    }

    /**
     * update artibut total_bonus menjadi 'total bonus yang di berikan oleh owner' update total_bonus 'sudah_di_berikan' 
     */
    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'bonus_id'    => 'required|exists:bonuses,id',
            'total_bonus' => 'required|numeric|min:0',
        ]);

        // ambil data bonus beserta relasi penilaian
        $bonus = Bonus::with('penilaian')
            ->findOrFail($validated['bonus_id']);

        // cek apakah bonus sebelumnya sudah pernah diisi
        $sudahPernahDiisi = !is_null($bonus->total_bonus);

        // update total bonus dan status bonus
        $bonus->update([
            'total_bonus'  => $validated['total_bonus'],
            'status_bonus' => 'sudah_di_berikan',
        ]);

        // jika bonus sudah pernah diisi sebelumnya
        // berarti owner sedang mengubah nominal bonus
        if ($sudahPernahDiisi) {

            $bonus->penilaian->update([
                'status_perhitungan' => 'hitung_ulang_saw',
            ]);

            return redirect()
                ->route('bonus.index')
                ->with(
                    'success',
                    'Total bonus berhasil diperbarui. Status perhitungan SAW diubah menjadi Hitung Ulang SAW.'
                );
        }

        // pertama kali mengisi bonus
        return redirect()
            ->route('bonus.index')
            ->with(
                'success',
                'Total bonus berhasil ditambahkan.'
            );
    }
    /**
     * menampilkan detail id bonus 
     */
    public function show(Bonus $bonus)
    {
        //
    }

    /**
     * menampilkan form edit untuk meng update data bonus
     */
    public function edit(Bonus $bonus)
    {
        $bonus = Bonus::with([
            'penilaian.detailPenilaians'
        ])->findOrFail($bonus->id);

        $bonus->periode_label = Carbon::parse(
            $bonus->penilaian->periode
        )->translatedFormat('F Y');

        $bonus->tanggal_penilaian_label = Carbon::parse(
            $bonus->penilaian->tanggal_penilaian
        )->translatedFormat('d F Y');

        $bonus->status_perhitungan =
            $bonus->penilaian->status_perhitungan;

        $bonus->jumlah_karyawan =
            $bonus->penilaian
            ->detailPenilaians
            ->pluck('karyawan_id')
            ->unique()
            ->count();

        $bonus->status_bonus =
            is_null($bonus->total_bonus)
            ? 'Belum Diberikan'
            : 'Sudah Diberikan';

        return view(
            'pages.bonus.edit',
            compact('bonus')
        );
    }

    /**
     * update artibut total_bonus menjadi 'total bonus yang di berikan oleh owner' update status_perhitungan dari tabel/model penilaian menjadi 'hitung_ulang_saw' 
     */
    public function update(Request $request, Bonus $bonus)
    {
        // validasi
        $validated = $request->validate([
            'total_bonus' => 'required|numeric|min:0',
        ]);

        // update bonus
        $bonus->update([
            'total_bonus' => $validated['total_bonus'],
            'status_bonus' => 'sudah_di_berikan',
        ]);

        // update status perhitungan penilaian
        $bonus->penilaian->update([
            'status_perhitungan' => 'hitung_ulang_saw',
        ]);

        return redirect()
            ->route('bonus.index')
            ->with(
                'success',
                'Total bonus berhasil diubah.'
            );
    }
}
