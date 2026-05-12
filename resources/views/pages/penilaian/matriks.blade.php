{{--
================================================================
pages/penilaian/matriks.blade.php
TAHAP 1 — Matriks Keputusan (X): nilai asli tiap karyawan.
Controller : PenilaianController@matriks
Route      : GET /penilaian/{id}/matriks → penilaian.matriks
================================================================
--}}
@extends('layouts.app')

@section('title', 'Matriks Keputusan — ' . $penilaian->periode_label)
@section('page-title', 'Matriks Keputusan')
@section('page-subtitle', 'Tahap 1 SAW — Nilai asli (X) tiap karyawan per kriteria')

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('penilaian.saw', $penilaian->id) }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">Matriks Keputusan (X)</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        <a href="{{ route('penilaian.normalisasi', $penilaian->id) }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-semibold px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md transition-all duration-200">
            Tahap 2: Normalisasi <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    {{-- ===== TAB NAVIGASI ===== --}}
    <div class="flex gap-2 mb-5 overflow-x-auto pb-1">
        @foreach ([['penilaian.saw', 'fa-calculator', 'Ringkasan SAW'], ['penilaian.matriks', 'fa-table', 'Matriks Keputusan'], ['penilaian.normalisasi', 'fa-divide', 'Normalisasi'], ['penilaian.ranking', 'fa-sort-amount-down', 'Ranking & Vi']] as [$routeName, $icon, $label])
            <a href="{{ route($routeName, $penilaian->id) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              {{ $routeName === 'penilaian.matriks'
                  ? 'bg-ocean text-white'
                  : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                <i class="fas {{ $icon }} text-xs"></i> {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- ===== INFO BOX ===== --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-5 flex items-start gap-3">
        <i class="fas fa-info-circle text-blue-400 mt-0.5 shrink-0"></i>
        <div class="text-sm text-blue-700">
            <strong>Matriks Keputusan (X)</strong> adalah tabel nilai mentah setiap karyawan untuk masing-masing kriteria.
            Nilai dengan tanda <span
                class="bg-teal/20 text-teal-800 px-1.5 py-0.5 rounded font-bold text-xs mx-1">Maks</span>
            adalah nilai tertinggi pada kolom tersebut, digunakan sebagai pembagi pada tahap normalisasi.
        </div>
    </div>

    {{-- ===== MATRIKS X ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-heading font-bold text-ocean text-[15px]">Matriks Keputusan (X)</h3>
            <div class="text-xs text-slate-400 font-mono">
                {{ $karyawans->count() }} × {{ $kriterias->count() }}
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" style="min-width:520px">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-5 py-3 bg-slate-50 border border-slate-200 min-w-[150px]">
                            Karyawan</th>
                        @foreach ($kriterias as $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-4 py-3 bg-slate-50 border border-slate-200">
                                {{ $k->kode }}<br>
                                <span
                                    class="font-normal normal-case text-[10px] tracking-normal">{{ $k->nama }}</span>
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
                                @php $v = $matriksX[$kar->id][$k->id] ?? 0; @endphp
                                <td
                                    class="px-4 py-3 border border-slate-200 text-center font-semibold
                               {{ $v == ($maxPerKriteria[$k->id] ?? 0) ? 'cell-best' : 'text-slate-700' }}">
                                    {{ $v }}
                                    @if ($v == ($maxPerKriteria[$k->id] ?? 0))
                                        <sup class="text-[9px] text-teal-600 font-bold ml-0.5">maks</sup>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                {{-- Baris Nilai MAX --}}
                <tfoot>
                    <tr class="bg-ocean/5">
                        <td class="px-5 py-3 border border-slate-200 font-bold text-ocean text-sm">
                            <i class="fas fa-arrow-up text-teal text-xs mr-1"></i>Max(X<sub>j</sub>)
                        </td>
                        @foreach ($kriterias as $k)
                            <td class="px-4 py-3 border border-slate-200 text-center font-bold text-teal-700 bg-teal-bg/60">
                                {{ $maxPerKriteria[$k->id] ?? '—' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr class="bg-slate-50/60">
                        <td class="px-5 py-3 border border-slate-200 font-bold text-slate-600 text-sm">
                            <i class="fas fa-arrow-down text-red-400 text-xs mr-1"></i>Min(X<sub>j</sub>)
                        </td>
                        @foreach ($kriterias as $k)
                            <td class="px-4 py-3 border border-slate-200 text-center font-bold text-slate-600">
                                {{ $minPerKriteria[$k->id] ?? '—' }}
                            </td>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- ===== RUMUS ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5">
        <h3 class="font-heading font-bold text-ocean text-[14px] mb-3">
            <i class="fas fa-info-circle text-teal mr-2"></i>Penjelasan Tahap Ini
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-slate-600">
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="font-semibold text-slate-800 mb-1">Pembentukan Matriks</p>
                <p class="text-xs leading-relaxed">
                    Setiap baris mewakili satu karyawan (alternatif), setiap kolom mewakili
                    satu kriteria. Nilai x<sub>ij</sub> adalah nilai karyawan <em>i</em> pada kriteria <em>j</em>.
                </p>
            </div>
            <div class="bg-teal-bg rounded-xl p-4 border border-teal-100">
                <p class="font-semibold text-teal-800 mb-1">Nilai Maksimum</p>
                <p class="text-xs leading-relaxed text-teal-700">
                    Max(X<sub>j</sub>) = nilai terbesar tiap kolom, digunakan sebagai pembagi
                    pada perhitungan normalisasi di Tahap 2.
                </p>
            </div>
        </div>
    </div>

@endsection
