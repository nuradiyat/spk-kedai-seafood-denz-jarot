{{--
================================================================
pages/penilaian/ranking.blade.php
TAHAP 3 — Pembobotan + Nilai Akhir Vi + Ranking karyawan.
Vi = Σ(wj × rij) untuk semua kriteria j.
Controller : PenilaianController@ranking
Route      : GET /penilaian/{id}/ranking → penilaian.ranking
================================================================
--}}
@extends('layouts.app')

@section('title', 'Ranking SAW — ' . $penilaian->periode_label)
@section('page-title', 'Nilai Akhir & Ranking')
@section('page-subtitle', 'Tahap 3 SAW — V(i) = Σ(w(j) × r(ij))')

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('penilaian.normalisasi', $penilaian->id) }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">Nilai Akhir & Ranking</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            @if ($penilaian->status === 'draft')
                <form method="POST" action="{{ route('hasil.proses', $penilaian->id) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal text-white
                           text-sm font-semibold px-5 py-2.5 rounded-xl hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <i class="fas fa-save text-xs"></i> Simpan Hasil SAW
                    </button>
                </form>
            @else
                <a href="{{ route('hasil.detail', $penilaian->id) }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
                  text-sm font-semibold px-5 py-2.5 rounded-xl hover:-translate-y-0.5 hover:shadow-md transition-all">
                    <i class="fas fa-trophy text-xs"></i> Lihat Hasil Final
                </a>
            @endif
        </div>
    </div>

    {{-- TAB NAVIGASI --}}
    <div class="flex gap-2 mb-5 overflow-x-auto pb-1">
        @foreach ([['penilaian.saw', 'fa-calculator', 'Ringkasan SAW'], ['penilaian.matriks', 'fa-table', 'Matriks Keputusan'], ['penilaian.normalisasi', 'fa-divide', 'Normalisasi'], ['penilaian.ranking', 'fa-sort-amount-down', 'Ranking & Vi']] as [$routeName, $icon, $label])
            <a href="{{ route($routeName, $penilaian->id) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              {{ $routeName === 'penilaian.ranking'
                  ? 'bg-ocean text-white'
                  : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                <i class="fas {{ $icon }} text-xs"></i> {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- ===== FORMULA ===== --}}
    <div class="bg-teal-bg border border-teal-200 rounded-2xl px-5 py-4 mb-5">
        <p class="text-xs font-bold text-teal-700 uppercase tracking-wide mb-1.5">Formula Nilai Akhir</p>
        <p class="font-mono text-sm text-teal-800">
            V<sub>i</sub> =
            @foreach ($kriterias as $idx => $k)
                ({{ $k->bobot }} × r<sub>i{{ $idx + 1 }}</sub>)
                {{ !$loop->last ? ' + ' : '' }}
            @endforeach
        </p>
    </div>

    {{-- ===== TABEL PEMBOBOTAN + NILAI VI ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-heading font-bold text-ocean text-[15px]">Matriks Pembobotan &amp; Nilai V<sub>i</sub></h3>
            <div class="text-xs text-slate-400">w<sub>j</sub> × r<sub>ij</sub> per sel → jumlah = V<sub>i</sub></div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" style="min-width:600px">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-5 py-3 bg-slate-50 border border-slate-200 min-w-[150px]">
                            Karyawan</th>
                        @foreach ($kriterias as $idx => $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-3 py-3 bg-slate-50 border border-slate-200">
                                w<sub>{{ $idx + 1 }}</sub>·r<sub>i{{ $idx + 1 }}</sub><br>
                                <span
                                    class="font-normal normal-case text-[10px] tracking-normal">{{ $k->kode }}</span>
                            </th>
                        @endforeach
                        <th
                            class="text-center text-[11px] font-bold text-teal-700 uppercase tracking-wide
                               px-4 py-3 bg-teal-bg border border-teal-200 min-w-[90px]">
                            V<sub>i</sub><br>
                            <span class="font-normal normal-case text-[10px] tracking-normal">Nilai Akhir</span>
                        </th>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-3 py-3 bg-slate-50 border border-slate-200">
                            Rank</th>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-3 py-3 bg-slate-50 border border-slate-200">
                            Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        /* Hitung Vi untuk setiap karyawan */
                        $viList = [];
                        foreach ($karyawans as $kar) {
                            $vi = 0;
                            $wrDetail = [];
                            foreach ($kriterias as $k) {
                                $xij = $matriksX[$kar->id][$k->id] ?? 0;
                                $maks = $maxPerKriteria[$k->id] ?? 1;
                                $mins = $minPerKriteria[$k->id] ?? 0;
                                $rij =
                                    $k->tipe === 'benefit'
                                        ? ($maks > 0
                                            ? $xij / $maks
                                            : 0)
                                        : ($xij > 0
                                            ? $mins / $xij
                                            : 0);
                                $wr = $k->bobot * $rij;
                                $wrDetail[$k->id] = $wr;
                                $vi += $wr;
                            }
                            $viList[$kar->id] = ['vi' => round($vi, 6), 'wr' => $wrDetail, 'karyawan' => $kar];
                        }
                        /* Urutkan berdasarkan Vi */
                        uasort($viList, fn($a, $b) => $b['vi'] <=> $a['vi']);
                        $rank = 1;
                        foreach ($viList as &$item) {
                            $item['rank'] = $rank++;
                        }
                        unset($item);

                        $rankBg = [1 => 'bg-yellow-50/50', 2 => 'bg-slate-50/30', 3 => 'bg-orange-50/30'];
                        $rankBadge = [
                            1 => 'bg-yellow-100 text-yellow-700',
                            2 => 'bg-slate-200 text-slate-600',
                            3 => 'bg-orange-100 text-orange-600',
                        ];
                    @endphp

                    @foreach ($viList as $karId => $item)
                        @php $kar = $item['karyawan']; @endphp
                        <tr class="{{ $rankBg[$item['rank']] ?? '' }}">
                            <td class="px-5 py-3 border border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0
                                         text-white text-[10px] font-bold font-heading
                                         bg-gradient-to-br {{ $kar->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($kar->nama, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $kar->nama }}</span>
                                </div>
                            </td>
                            @foreach ($kriterias as $k)
                                <td class="px-3 py-3 border border-slate-200 text-center text-[12px]">
                                    <div class="font-mono font-semibold text-slate-800">
                                        {{ number_format($item['wr'][$k->id] ?? 0, 4) }}
                                    </div>
                                    <div class="text-[10px] text-slate-400">
                                        {{ $k->bobot }}×r
                                    </div>
                                </td>
                            @endforeach
                            <td
                                class="px-4 py-3 border border-teal-200 text-center bg-teal-bg/60
                               font-heading font-bold text-base
                               {{ $item['rank'] <= 2 ? 'text-teal-800' : ($item['rank'] <= 4 ? 'text-teal-700' : 'text-slate-500') }}">
                                {{ number_format($item['vi'], 4) }}
                            </td>
                            <td class="px-3 py-3 border border-slate-200 text-center">
                                <span
                                    class="{{ $rankBadge[$item['rank']] ?? 'bg-slate-100 text-slate-400' }}
                                     inline-flex items-center justify-center w-7 h-7 rounded-lg
                                     font-heading font-bold text-sm">
                                    {{ $item['rank'] }}
                                </span>
                            </td>
                            <td class="px-3 py-3 border border-slate-200 text-center">
                                @if ($item['rank'] <= 4)
                                    @include('components.badges.status', ['status' => 'bonus'])
                                @elseif($item['rank'] == 5)
                                    @include('components.badges.status', ['status' => 'pertimbangan'])
                                @else
                                    @include('components.badges.status', ['status' => 'tidak'])
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== KESIMPULAN ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5">
        <h3 class="font-heading font-bold text-ocean text-[15px] mb-4">
            <i class="fas fa-check-circle text-teal mr-2"></i>Kesimpulan Perangkingan
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @php
                $rankIcons = [1 => '🥇', 2 => '🥈', 3 => '🥉'];
                $rankBadgeCs = [
                    1 => 'bg-yellow-100 text-yellow-700',
                    2 => 'bg-slate-100 text-slate-600',
                    3 => 'bg-orange-100 text-orange-600',
                    4 => 'bg-teal-bg text-teal-700',
                ];
            @endphp
            @foreach (array_slice($viList, 0, 4, true) as $karId => $item)
                <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-200">
                    <span class="text-xl shrink-0">{{ $rankIcons[$item['rank']] ?? '🏅' }}</span>
                    <span
                        class="{{ $rankBadgeCs[$item['rank']] ?? 'bg-slate-100 text-slate-500' }}
                          inline-flex items-center justify-center w-6 h-6 rounded-lg
                          font-heading font-bold text-xs shrink-0">
                        {{ $item['rank'] }}
                    </span>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $item['karyawan']->nama }}</p>
                        <p class="text-xs text-slate-400">
                            V<sub>i</sub> = <span
                                class="font-mono font-bold text-teal-600">{{ number_format($item['vi'], 4) }}</span>
                            — Penerima Bonus
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($penilaian->status === 'draft')
            <div class="mt-4 flex justify-end">
                <form method="POST" action="{{ route('hasil.proses', $penilaian->id) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal text-white
                           text-sm font-semibold px-6 py-2.5 rounded-xl hover:-translate-y-0.5
                           hover:shadow-md transition-all duration-200">
                        <i class="fas fa-database text-xs"></i> Simpan Hasil ke Database
                    </button>
                </form>
            </div>
        @endif
    </div>

@endsection
