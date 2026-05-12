{{--
================================================================
pages/penilaian/detail.blade.php
Detail rekap nilai satu penilaian + navigasi ke tahapan SAW.
Controller : PenilaianController@show
Route      : GET /penilaian/{id} → penilaian.show
================================================================
--}}
@extends('layouts.app')

@section('title', 'Detail Penilaian — ' . $penilaian->periode_label)
@section('page-title', 'Detail Penilaian')
@section('page-subtitle', 'Rekap nilai — ' . $penilaian->periode_label)

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('penilaian.index') }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">{{ $penilaian->judul }}</h2>
                <p class="text-slate-400 text-sm mt-0.5">Periode: {{ $penilaian->periode_label }}</p>
            </div>
        </div>
        <div class="flex gap-2 flex-wrap justify-end">
            @if ($penilaian->status === 'draft')
                <a href="{{ route('penilaian.edit', $penilaian->id) }}"
                    class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-600
                  text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                    <i class="fas fa-pen text-xs"></i> Edit Nilai
                </a>
                <form method="POST" action="{{ route('hasil.proses', $penilaian->id) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal
                           text-white text-sm font-semibold px-4 py-2.5 rounded-xl
                           hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-calculator text-xs"></i> Proses SAW
                    </button>
                </form>
            @else
                <a href="{{ route('hasil.detail', $penilaian->id) }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
                  text-sm font-semibold px-4 py-2.5 rounded-xl hover:-translate-y-0.5 hover:shadow-md transition-all">
                    <i class="fas fa-trophy text-xs"></i> Lihat Hasil
                </a>
            @endif
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
        @foreach ([['Periode', $penilaian->periode_label, 'fa-calendar', 'ocean'], ['Karyawan', $penilaian->total_karyawan, 'fa-users', 'sea'], ['Status', ucfirst($penilaian->status), 'fa-toggle-on', $penilaian->status === 'selesai' ? 'sea' : 'warn'], ['Dibuat', $penilaian->created_at->translatedFormat('d M Y'), 'fa-clock', 'ocean']] as [$lbl, $val, $icon, $color])
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="flex items-center gap-2 mb-2">
                    <div
                        class="w-7 h-7 rounded-lg
                        {{ $color === 'sea' ? 'bg-teal/10 text-teal-700' : ($color === 'warn' ? 'bg-amber-100 text-amber-600' : 'bg-ocean/10 text-ocean') }}
                        flex items-center justify-center text-xs">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">{{ $lbl }}</p>
                </div>
                <div class="font-heading font-bold text-ocean text-sm">{{ $val }}</div>
            </div>
        @endforeach
    </div>

    {{-- Tab Navigasi SAW --}}
    <div class="flex gap-2 mb-4 overflow-x-auto pb-1">
        <a href="{{ route('penilaian.show', $penilaian->id) }}"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              bg-ocean text-white">
            <i class="fas fa-table text-xs"></i> Matriks Nilai
        </a>
        <a href="{{ route('penilaian.matriks', $penilaian->id) }}"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">
            <i class="fas fa-grip text-xs"></i> Matriks Keputusan
        </a>
        <a href="{{ route('penilaian.normalisasi', $penilaian->id) }}"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">
            <i class="fas fa-divide text-xs"></i> Normalisasi
        </a>
        <a href="{{ route('penilaian.ranking', $penilaian->id) }}"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">
            <i class="fas fa-sort-amount-down text-xs"></i> Ranking
        </a>
        @if ($penilaian->status === 'selesai')
            <a href="{{ route('hasil.detail', $penilaian->id) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              bg-teal-bg border border-teal-200 text-teal-700 hover:bg-teal-100">
                <i class="fas fa-trophy text-xs"></i> Hasil Final
            </a>
        @endif
    </div>

    {{-- Tabel Matriks Nilai Asli --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-heading font-bold text-ocean text-[15px]">Matriks Nilai (X)</h3>
            <div class="text-xs text-slate-400">Nilai asli per karyawan per kriteria — skala 1–5</div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" style="min-width:500px">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-5 py-3 bg-slate-50 border border-slate-200 min-w-[150px]">
                            Karyawan</th>
                        @foreach ($kriterias as $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                               px-3 py-3 bg-slate-50 border border-slate-200">
                                {{ $k->kode }}<br>
                                <span class="font-normal normal-case text-[10px]">{{ $k->nama }}</span>
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
                                        class="w-7 h-7 rounded-lg flex items-center justify-center
                                         text-white text-[10px] font-bold font-heading shrink-0
                                         bg-gradient-to-br {{ $kar->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($kar->nama, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $kar->nama }}</span>
                                </div>
                            </td>
                            @foreach ($kriterias as $k)
                                @php $v = $nilaiMatrix[$kar->id][$k->id] ?? null; @endphp
                                <td
                                    class="px-3 py-3 border border-slate-200 text-center
                               {{ $v == 5 ? 'cell-best' : ($v == 1 ? 'bg-red-50 text-red-600' : 'text-slate-700') }}
                               font-semibold">
                                    {{ $v ?? '—' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
