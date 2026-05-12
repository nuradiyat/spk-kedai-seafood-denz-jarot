{{--
================================================================
pages/penilaian/normalisasi.blade.php
TAHAP 2 — Matriks Normalisasi (R).
rij = xij / max(xij)  → Benefit
rij = min(xij) / xij  → Cost
Controller : PenilaianController@normalisasi
Route      : GET /penilaian/{id}/normalisasi → penilaian.normalisasi
================================================================
--}}
@extends('layouts.app')

@section('title', 'Normalisasi — ' . $penilaian->periode_label)
@section('page-title', 'Matriks Normalisasi')
@section('page-subtitle', 'Tahap 2 SAW — Normalisasi nilai r(ij)')

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('penilaian.matriks', $penilaian->id) }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">Matriks Normalisasi (R)</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        <a href="{{ route('penilaian.ranking', $penilaian->id) }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-semibold px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md transition-all duration-200">
            Tahap 3: Ranking <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    {{-- TAB NAVIGASI --}}
    <div class="flex gap-2 mb-5 overflow-x-auto pb-1">
        @foreach ([['penilaian.saw', 'fa-calculator', 'Ringkasan SAW'], ['penilaian.matriks', 'fa-table', 'Matriks Keputusan'], ['penilaian.normalisasi', 'fa-divide', 'Normalisasi'], ['penilaian.ranking', 'fa-sort-amount-down', 'Ranking & Vi']] as [$routeName, $icon, $label])
            <a href="{{ route($routeName, $penilaian->id) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              {{ $routeName === 'penilaian.normalisasi'
                  ? 'bg-ocean text-white'
                  : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                <i class="fas {{ $icon }} text-xs"></i> {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- ===== RUMUS BOX ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-1.5">Rumus Benefit</p>
            <p class="font-mono text-sm text-blue-800">
                r<sub>ij</sub> = x<sub>ij</sub> ÷ Max(x<sub>ij</sub>)
            </p>
            <p class="text-xs text-blue-600 mt-1">Nilai lebih besar = lebih baik</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
            <p class="text-xs font-bold text-amber-700 uppercase tracking-wide mb-1.5">Rumus Cost</p>
            <p class="font-mono text-sm text-amber-800">
                r<sub>ij</sub> = Min(x<sub>ij</sub>) ÷ x<sub>ij</sub>
            </p>
            <p class="text-xs text-amber-600 mt-1">Nilai lebih kecil = lebih baik</p>
        </div>
    </div>

    {{-- ===== STRIP BOBOT KRITERIA ===== --}}
    <div class="flex flex-wrap items-center gap-2 bg-white border border-slate-200 rounded-2xl p-4 mb-5">
        @foreach ($kriterias as $k)
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                <span class="font-heading font-bold text-ocean text-xs">{{ $k->kode }}</span>
                <span class="text-[10px] text-slate-400">{{ $k->nama }}</span>
                <span
                    class="text-xs font-bold px-2 py-0.5 rounded-lg
                     {{ $k->tipe === 'benefit' ? 'bg-teal-bg text-teal-700 border border-teal-200' : 'bg-red-50 text-red-600 border border-red-200' }}">
                    {{ strtoupper($k->tipe) }}
                </span>
                <span class="text-xs font-bold text-ocean/70">W={{ $k->bobot }}</span>
            </div>
        @endforeach
    </div>

    {{-- ===== MATRIKS NORMALISASI ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-heading font-bold text-ocean text-[15px]">Matriks Normalisasi (R)</h3>
            <div class="text-xs text-slate-400">r<sub>ij</sub> = hasil normalisasi | hijau = nilai 1.00 (tertinggi)</div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" style="min-width:560px">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-5 py-3 bg-slate-50 border border-slate-200 min-w-[150px]">
                            Karyawan</th>
                        @foreach ($kriterias as $idx => $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-4 py-3 bg-slate-50 border border-slate-200">
                                r<sub>i{{ $idx + 1 }}</sub><br>
                                <span class="font-normal normal-case text-[10px] tracking-normal">
                                    {{ $k->kode }} ÷
                                    {{ $k->tipe === 'benefit' ? 'Max' : 'Min' }}={{ $maxPerKriteria[$k->id] ?? '?' }}
                                </span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $kar)
                        <tr class="{{ $loop->odd ? 'bg-slate-50/40' : 'bg-white' }}">
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
                                @php
                                    $xij = $matriksX[$kar->id][$k->id] ?? 0;
                                    $maks = $maxPerKriteria[$k->id] ?? 1;
                                    $mins = $minPerKriteria[$k->id] ?? 0;
                                    $rij =
                                        $k->tipe === 'benefit'
                                            ? ($maks > 0
                                                ? round($xij / $maks, 4)
                                                : 0)
                                            : ($xij > 0
                                                ? round($mins / $xij, 4)
                                                : 0);
                                @endphp
                                <td
                                    class="px-3 py-3 border border-slate-200 text-center text-[12.5px]
                               {{ $rij == 1.0 ? 'cell-best' : 'text-slate-700' }}">
                                    <div class="font-mono font-semibold">{{ number_format($rij, 4) }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        {{ $xij }}/{{ $k->tipe === 'benefit' ? $maks : $mins }}
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== KETERANGAN ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5">
        <h3 class="font-heading font-bold text-ocean text-[14px] mb-3">Penjelasan Normalisasi</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="flex items-start gap-2.5 p-3 bg-teal-bg rounded-xl border border-teal-100">
                <span
                    class="w-6 h-6 rounded-lg bg-teal/20 text-teal-700 flex items-center justify-center text-xs font-bold shrink-0">1</span>
                <p class="text-xs text-teal-700 leading-relaxed">
                    Nilai <strong>r = 1.00</strong> artinya karyawan tersebut mendapat nilai terbaik pada kriteria itu.
                </p>
            </div>
            <div class="flex items-start gap-2.5 p-3 bg-amber-50 rounded-xl border border-amber-100">
                <span
                    class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold shrink-0">2</span>
                <p class="text-xs text-amber-700 leading-relaxed">
                    Nilai r antara <strong>0–1</strong>, semakin mendekati 1 semakin baik performa karyawan.
                </p>
            </div>
            <div class="flex items-start gap-2.5 p-3 bg-blue-50 rounded-xl border border-blue-100">
                <span
                    class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold shrink-0">3</span>
                <p class="text-xs text-blue-700 leading-relaxed">
                    Hasil normalisasi ini selanjutnya <strong>dikalikan bobot</strong> untuk mendapat nilai akhir
                    V<sub>i</sub>.
                </p>
            </div>
        </div>
    </div>

@endsection
