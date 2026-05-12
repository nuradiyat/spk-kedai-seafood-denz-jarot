{{--
================================================================
pages/penilaian/saw.blade.php
Halaman ringkasan proses SAW dengan navigasi antar tahapan.
Controller : PenilaianController@saw
Route      : GET /penilaian/{id}/saw → penilaian.saw
================================================================
--}}
@extends('layouts.app')

@section('title', 'Perhitungan SAW — ' . $penilaian->periode_label)
@section('page-title', 'Perhitungan SAW')
@section('page-subtitle', 'Simple Additive Weighting — ' . $penilaian->periode_label)

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('penilaian.show', $penilaian->id) }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">Perhitungan SAW</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        @if ($penilaian->status === 'draft')
            <form method="POST" action="{{ route('hasil.proses', $penilaian->id) }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal
                       text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                       hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                    <i class="fas fa-play text-xs"></i> Proses & Simpan
                </button>
            </form>
        @endif
    </div>

    {{-- Tab Navigasi --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
        @foreach ([['saw', 'fa-calculator', 'Ringkasan SAW'], ['matriks', 'fa-table', 'Matriks Keputusan'], ['normalisasi', 'fa-divide', 'Normalisasi'], ['ranking', 'fa-sort-amount-down', 'Ranking & Vi']] as [$name, $icon, $label])
            <a href="{{ route('penilaian.' . $name, $penilaian->id) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors
              {{ $name === 'saw' ? 'bg-ocean text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                <i class="fas {{ $icon }} text-xs"></i> {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Bobot Strip --}}
    <div class="flex flex-wrap items-center gap-2 bg-white border border-slate-200 rounded-2xl p-4 mb-5">
        @foreach ($kriterias as $idx => $k)
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                <span class="font-heading font-bold text-ocean text-xs">{{ $k->kode }}</span>
                <span class="text-slate-400 text-xs">{{ $k->nama }}</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-lg bg-teal-bg text-teal-700 border border-teal-200">
                    W={{ $k->bobot }}
                </span>
            </div>
        @endforeach
        <div class="ml-auto text-xs font-bold text-teal">Σ W = {{ $kriterias->sum('bobot') }} ✓</div>
    </div>

    {{-- Langkah-langkah SAW --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
        @php
            $steps = [
                [
                    'num' => 1,
                    'title' => 'Matriks Keputusan',
                    'desc' => 'Nilai mentah xij tiap karyawan',
                    'route' => 'penilaian.matriks',
                    'icon' => 'fa-table',
                    'color' => 'bg-blue-50 text-blue-600',
                ],
                [
                    'num' => 2,
                    'title' => 'Normalisasi',
                    'desc' => 'rij = xij / max(xij) (benefit)',
                    'route' => 'penilaian.normalisasi',
                    'icon' => 'fa-divide',
                    'color' => 'bg-amber-50 text-amber-600',
                ],
                [
                    'num' => 3,
                    'title' => 'Nilai Vi & Ranking',
                    'desc' => 'Vi = Σ(wj × rij)',
                    'route' => 'penilaian.ranking',
                    'icon' => 'fa-trophy',
                    'color' => 'bg-teal-bg text-teal-700',
                ],
            ];
        @endphp
        @foreach ($steps as $step)
            <a href="{{ route($step['route'], $penilaian->id) }}"
                class="bg-white rounded-2xl border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md
              transition-all duration-200 group">
                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl {{ $step['color'] }} flex items-center justify-center text-lg shrink-0">
                        <i class="fas {{ $step['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tahap
                                {{ $step['num'] }}</span>
                        </div>
                        <p class="font-heading font-bold text-ocean text-[15px]">{{ $step['title'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5 font-mono">{{ $step['desc'] }}</p>
                    </div>
                </div>
                <div
                    class="mt-4 flex items-center justify-end text-teal text-xs font-medium
                    opacity-0 group-hover:opacity-100 transition-opacity">
                    Buka tahap ini <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Formula Box --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-heading font-bold text-ocean text-[15px] mb-4">
            <i class="fas fa-function text-teal mr-2"></i>Formula SAW
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-2">Normalisasi (Benefit)</p>
                <p class="font-mono text-sm text-blue-800">r<sub>ij</sub> = x<sub>ij</sub> ÷ Max(x<sub>ij</sub>)</p>
            </div>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <p class="text-xs font-bold text-amber-700 uppercase tracking-wide mb-2">Normalisasi (Cost)</p>
                <p class="font-mono text-sm text-amber-800">r<sub>ij</sub> = Min(x<sub>ij</sub>) ÷ x<sub>ij</sub></p>
            </div>
            <div class="bg-teal-bg border border-teal-200 rounded-xl p-4 md:col-span-2">
                <p class="text-xs font-bold text-teal-700 uppercase tracking-wide mb-2">Nilai Akhir</p>
                <p class="font-mono text-sm text-teal-800">
                    V<sub>i</sub> =
                    @foreach ($kriterias as $idx => $k)
                        ({{ $k->bobot }} × r<sub>i{{ $idx + 1 }}</sub>)
                        {{ !$loop->last ? ' + ' : '' }}
                    @endforeach
                </p>
            </div>
        </div>
    </div>

@endsection
