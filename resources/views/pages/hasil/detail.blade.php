@extends('layouts.app')

@section('title', 'Detail Perhitungan SAW')

@section('content')
<x-page-header :title="'Detail Matriks Perhitungan SAW · '.$penilaian->periode" subtitle="Transparansi perhitungan langkah demi langkah metode SAW" :crumbs="['Metode SAW', 'Hasil SAW', 'Detail Perhitungan']">
    <x-slot name="actions">
        <a href="{{ route('hasil.index', ['periode' => $penilaian->id]) }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Hasil
        </a>
        <a href="{{ route('hasil.export', $penilaian->id) }}" class="btn btn-primary">
            <x-icon name="file-down" class="h-4 w-4" /> Export PDF
        </a>
    </x-slot>
</x-page-header>

<div class="space-y-6">
    {{-- ===================================== --}}
    {{-- 1. MATRIX AWAL --}}
    {{-- ===================================== --}}
    <x-card class="overflow-hidden">
        <x-card-header title="1. Matriks Keputusan Awal (X)" subtitle="Data nilai alternatif karyawan terhadap masing-masing kriteria" icon="grid" />
        <div class="overflow-x-auto">
            <table class="tbl min-w-[640px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th">Karyawan</th>
                        @foreach($hasil['kriterias'] as $kriteria)
                            <th class="tbl-th text-center">
                                <span class="font-bold text-slate-700">{{ $kriteria->kode }}</span>
                                <span class="block text-[10px] text-slate-400 capitalize">({{ $kriteria->jenis }})</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @foreach($hasil['karyawans'] as $karyawan)
                        <tr class="tbl-row">
                            <td class="tbl-td font-semibold text-slate-900">
                                {{ $karyawan->nama_karyawan }}
                            </td>
                            @foreach($hasil['kriterias'] as $kriteria)
                                <td class="tbl-td text-center tabular-nums text-slate-700">
                                    {{ $hasil['nilai_awal'][$karyawan->id][$kriteria->id] ?? 0 }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- ===================================== --}}
    {{-- 2. MAX & MIN --}}
    {{-- ===================================== --}}
    <div class="grid gap-5 md:grid-cols-3">
        <x-card class="overflow-hidden md:col-span-2">
            <x-card-header title="2. Nilai Ekstrem Kriteria (Max & Min)" subtitle="Digunakan sebagai pembagi normalisasi sesuai atribut kriteria" icon="scale" />
            <div class="overflow-x-auto">
                <table class="tbl min-w-[480px]">
                    <thead class="tbl-head">
                        <tr>
                            <th class="tbl-th">Kriteria</th>
                            <th class="tbl-th">Nama Kriteria</th>
                            <th class="tbl-th">Jenis Atribut</th>
                            <th class="tbl-th text-center">Nilai Max</th>
                            <th class="tbl-th text-center">Nilai Min</th>
                        </tr>
                    </thead>
                    <tbody class="tbl-body">
                        @foreach($hasil['kriterias'] as $kriteria)
                            <tr class="tbl-row">
                                <td class="tbl-td font-bold text-indigo-600">{{ $kriteria->kode }}</td>
                                <td class="tbl-td font-medium text-slate-800">{{ $kriteria->nama_kriteria }}</td>
                                <td class="tbl-td">
                                    @if(strtolower($kriteria->jenis) === 'benefit')
                                        <x-badge tone="emerald" icon="trending-up">Benefit</x-badge>
                                    @else
                                        <x-badge tone="rose" icon="trending-down">Cost</x-badge>
                                    @endif
                                </td>
                                <td class="tbl-td text-center font-bold tabular-nums text-slate-900">{{ $hasil['max'][$kriteria->id] ?? 0 }}</td>
                                <td class="tbl-td text-center font-bold tabular-nums text-slate-900">{{ $hasil['min'][$kriteria->id] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>

        <x-card class="flex flex-col justify-center p-6">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                <x-icon name="info" class="h-5 w-5" />
            </span>
            <h3 class="mt-4 font-bold text-slate-900">Rumus Normalisasi Matriks</h3>
            <p class="mt-2 text-xs leading-relaxed text-slate-600">
                <b>Benefit:</b> \( r_{ij} = \frac{x_{ij}}{\max(x_{ij})} \)<br>
                <i>(Nilai dibagi Nilai Maksimal)</i>
            </p>
            <p class="mt-2 text-xs leading-relaxed text-slate-600">
                <b>Cost:</b> \( r_{ij} = \frac{\min(x_{ij})}{x_{ij}} \)<br>
                <i>(Nilai Minimal dibagi Nilai)</i>
            </p>
        </x-card>
    </div>

    {{-- ===================================== --}}
    {{-- 3. NORMALISASI --}}
    {{-- ===================================== --}}
    <x-card class="overflow-hidden">
        <x-card-header title="3. Matriks Ternormalisasi (R)" subtitle="Skala seragam dari hasil perbandingan dengan nilai ekstrem" icon="sigma" />
        <div class="overflow-x-auto">
            <table class="tbl min-w-[640px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th">Karyawan</th>
                        @foreach($hasil['kriterias'] as $kriteria)
                            <th class="tbl-th text-center">{{ $kriteria->kode }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @foreach($hasil['karyawans'] as $karyawan)
                        <tr class="tbl-row">
                            <td class="tbl-td font-semibold text-slate-900">
                                {{ $karyawan->nama_karyawan }}
                            </td>
                            @foreach($hasil['kriterias'] as $kriteria)
                                <td class="tbl-td text-center font-mono font-semibold tabular-nums text-indigo-600">
                                    {{ number_format($hasil['normalisasi'][$karyawan->id][$kriteria->id] ?? 0, 3) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- ===================================== --}}
    {{-- 4. MATRIX TERBOBOT & NILAI AKHIR --}}
    {{-- ===================================== --}}
    <x-card class="overflow-hidden">
        <x-card-header title="4. Matriks Terbobot & Nilai Preferensi Akhir (V)" subtitle="Hasil perkalian matriks ternormalisasi dengan bobot preferensi kriteria: V = Σ (w * r)" icon="chart" />
        <div class="overflow-x-auto">
            <table class="tbl min-w-[720px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th">Karyawan</th>
                        @foreach($hasil['kriterias'] as $kriteria)
                            <th class="tbl-th text-center">
                                <span>{{ $kriteria->kode }}</span>
                                <span class="block text-[10px] text-slate-400">w: {{ number_format((float) $kriteria->bobot, 2) }}</span>
                            </th>
                        @endforeach
                        <th class="tbl-th text-right font-bold text-slate-900">Total Nilai (V)</th>
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @foreach($hasil['karyawans'] as $karyawan)
                        @php
                            $nilaiTotal = $hasil['nilai_akhir'][$karyawan->id] ?? 0;
                        @endphp
                        <tr class="tbl-row">
                            <td class="tbl-td font-semibold text-slate-900">
                                {{ $karyawan->nama_karyawan }}
                            </td>
                            @foreach($hasil['kriterias'] as $kriteria)
                                <td class="tbl-td text-center tabular-nums text-slate-600">
                                    {{ number_format($hasil['terbobot'][$karyawan->id][$kriteria->id] ?? 0, 3) }}
                                </td>
                            @endforeach
                            <td class="tbl-td text-right font-bold tabular-nums text-indigo-600">
                                {{ number_format($nilaiTotal, 3) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection