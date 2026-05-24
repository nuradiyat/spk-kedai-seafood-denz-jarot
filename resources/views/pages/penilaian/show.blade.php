{{--
================================================================
pages/penilaian/show.blade.php

FUNGSI  :
Menampilkan detail nilai mentah penilaian karyawan
berdasarkan periode tertentu.

CATATAN :
- Halaman ini hanya menampilkan data input penilaian.
- Tidak ada proses perhitungan SAW di halaman ini.
- Perhitungan SAW dilakukan pada halaman hasil/index.blade.php

Controller : PenilaianController@show
Route      : GET /penilaian/{id} → penilaian.show
================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Penilaian — ' . \Carbon\Carbon::createFromFormat('Y-m',
    $penilaian->periode)->translatedFormat('F Y'))

@section('page-title', 'Detail Penilaian')

@section('page-subtitle', 'Nilai mentah karyawan — ' . \Carbon\Carbon::createFromFormat('Y-m',
    $penilaian->periode)->translatedFormat('F Y'))

@section('content')

    {{-- ============================================================
     BREADCRUMB
    ============================================================ --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-5">

        <a href="{{ route('dashboard') }}" class="hover:text-ocean transition-colors">
            Dashboard
        </a>

        <i class="fas fa-chevron-right text-[10px]"></i>

        <a href="{{ route('penilaian.index') }}" class="hover:text-ocean transition-colors">
            Input Penilaian
        </a>

        <i class="fas fa-chevron-right text-[10px]"></i>

        <span class="text-slate-600 font-medium">
            {{ \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('F Y') }}
        </span>

    </nav>

    {{-- ============================================================
     HEADER
    ============================================================ --}}
    <div class="flex items-center justify-between mb-6">

        <div class="flex items-center gap-3">

            <a href="{{ route('penilaian.index') }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                       flex items-center justify-center hover:bg-slate-50 transition-colors">

                <i class="fas fa-arrow-left text-sm"></i>

            </a>

            <div>

                <h1 class="font-heading font-bold text-ocean text-2xl">
                    Detail Penilaian
                </h1>

                <p class="text-slate-400 text-sm mt-0.5">
                    Periode :
                    <span class="font-semibold text-ocean">
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('F Y') }}
                    </span>
                </p>

            </div>

        </div>

        {{-- Tombol aksi --}}
        <div class="flex items-center gap-2">

            <a href="{{ route('penilaian.edit', $penilaian->id) }}"
                class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-600
                       text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">

                <i class="fas fa-pen text-xs"></i>

                Edit Nilai

            </a>

            <a href="{{ route('hasil.index', ['penilaian_id' => $penilaian->id]) }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
                       text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
                       hover:shadow-md hover:shadow-ocean/25 transition-all duration-200">

                <i class="fas fa-calculator text-xs"></i>

                Hitung SAW

            </a>

        </div>

    </div>

    {{-- ============================================================
     INFO CARD
    ============================================================ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- Card Periode --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-ocean/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-calendar-alt text-ocean text-base"></i>
                </div>

                <div>

                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                        Periode
                    </p>

                    <p class="font-heading font-bold text-ocean text-sm mt-0.5">
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('M Y') }}
                    </p>

                </div>

            </div>

        </div>

        {{-- Card Karyawan --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-users text-blue-500 text-base"></i>
                </div>

                <div>

                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                        Karyawan
                    </p>

                    <p class="font-heading font-bold text-ocean text-sm mt-0.5">
                        {{ $karyawans->count() }} orang
                    </p>

                </div>

            </div>

        </div>

        {{-- Card Kriteria --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-sliders-h text-purple-500 text-base"></i>
                </div>

                <div>

                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                        Kriteria
                    </p>

                    <p class="font-heading font-bold text-ocean text-sm mt-0.5">
                        {{ $kriterias->count() }} kriteria
                    </p>

                </div>

            </div>

        </div>

        {{-- Card Status SAW --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="flex items-center gap-3">

                <div
                    class="w-10 h-10 rounded-xl shrink-0 flex items-center justify-center
                    {{ $penilaian->hasilSaws->count() > 0 ? 'bg-teal-bg' : 'bg-amber-50' }}">

                    <i
                        class="text-base
                        {{ $penilaian->hasilSaws->count() > 0 ? 'fas fa-check-circle text-teal-600' : 'fas fa-clock text-amber-500' }}">
                    </i>

                </div>

                <div>

                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                        Status SAW
                    </p>

                    <p
                        class="font-heading font-bold text-sm mt-0.5
                        {{ $penilaian->hasilSaws->count() > 0 ? 'text-teal-700' : 'text-amber-600' }}">

                        {{ $penilaian->hasilSaws->count() > 0 ? 'Sudah Dihitung' : 'Belum Dihitung' }}

                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- ============================================================
     TABEL NILAI MENTAH
    ============================================================ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-5">

        {{-- Header tabel --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">

            <div class="flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg bg-ocean/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-table text-ocean text-sm"></i>
                </div>

                <div>

                    <h3 class="font-heading font-bold text-ocean text-[15px]">
                        Nilai Mentah Karyawan
                    </h3>

                    <p class="text-slate-400 text-xs mt-0.5">
                        Data asli hasil input admin
                    </p>

                </div>

            </div>

            <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg font-medium">
                Skala 1–5
            </span>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm" style="min-width: {{ 220 + $kriterias->count() * 100 }}px">

                <thead class="bg-slate-50 border border-slate-200">

                    <tr>

                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-6 py-3.5 min-w-[200px]">

                            Karyawan

                        </th>

                        @foreach ($kriterias as $kriteria)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                       px-4 py-3.5 min-w-[90px]">

                                <span class="#">
                                    {{ $kriteria->kode }}
                                </span>

                                <span class="#">
                                    {{ Str::limit($kriteria->nama, 12) }}
                                </span>

                            </th>
                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @foreach ($karyawans as $karyawan)
                        <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/40 transition-colors">

                            {{-- Nama karyawan --}}
                            <td class="px-6 py-3.5">

                                <div class="flex items-center gap-3">

                                    <span
                                        class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                                               text-white text-xs font-bold font-heading
                                               bg-gradient-to-br {{ $karyawan->warna ?? 'from-slate-400 to-slate-600' }}">

                                        {{ strtoupper(substr($karyawan->nama_karyawan, 0, 2)) }}

                                    </span>

                                    <div>

                                        <p class="font-semibold text-slate-800 text-sm">
                                            {{ $karyawan->nama_karyawan }}
                                        </p>

                                        <p class="text-[11px] text-slate-400">
                                            {{ $karyawan->jabatan ?? '—' }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Nilai per kriteria --}}
                            @foreach ($kriterias as $kriteria)
                                @php
                                    $nilaiKriteria = $nilaiMatrix[$karyawan->id][$kriteria->id] ?? null;

                                    // Kumpulkan semua nilai untuk kriteria ini dari semua karyawan
                                    $semuaNilai = [];

                                    foreach ($nilaiMatrix as $dataKaryawan) {
                                        if (isset($dataKaryawan[$kriteria->id])) {
                                            $semuaNilai[] = $dataKaryawan[$kriteria->id];
                                        }
                                    }

                                    $nilaiTertinggi = !empty($semuaNilai) ? max($semuaNilai) : 0;
                                    $nilaiTerendah = !empty($semuaNilai) ? min($semuaNilai) : 0;

                                    // Tentukan warna berdasarkan nilai
                                    if ($nilaiKriteria === null) {
                                        $warnaNilai = 'bg-slate-50 text-slate-300';
                                    } elseif ($nilaiKriteria == $nilaiTertinggi) {
                                        // Nilai terbaik
                                        $warnaNilai = '
                                        bg-green-50
                                        text-green-700
                                        border border-green-200
                                        font-bold';
                                        
                                    } elseif ($nilaiKriteria == $nilaiTerendah) {
                                        // Nilai terendah
                                        $warnaNilai = '
                                            bg-red-50
                                            text-red-600
                                            border border-red-200
                                            font-semibold';
                                            
                                    } else {
                                        // Nilai tengah
                                        $warnaNilai = '
                                        bg-slate-50
                                        text-slate-700
                                        border border-slate-200';
                                    }
                                @endphp

                                <td class="px-4 py-3.5 text-center">

                                    <span
                                        class="inline-flex items-center justify-center
                                               w-9 h-9 rounded-xl text-sm
                                               border border-slate-100
                                               {{ $warnaNilai }}">

                                        {{ $nilaiKriteria ?? '—' }}

                                    </span>

                                </td>
                            @endforeach

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{-- ============================================================
     CALL TO ACTION
    ============================================================ --}}
    <div class="bg-gradient-to-r from-ocean to-ocean-lt rounded-2xl p-6 flex items-center justify-between gap-4">

        <div class="text-white">

            <p class="font-heading font-bold text-lg">
                Siap menghitung SAW?
            </p>

            <p class="text-white/70 text-sm mt-1">
                Jalankan proses perhitungan SAW untuk mendapatkan hasil ranking karyawan.
            </p>

        </div>

        <a href="{{ route('hasil.index', ['penilaian_id' => $penilaian->id]) }}"
            class="shrink-0 inline-flex items-center gap-2 bg-white text-ocean
                   text-sm font-bold px-6 py-3 rounded-xl hover:-translate-y-0.5
                   hover:shadow-xl transition-all duration-200">

            <i class="fas fa-calculator text-sm"></i>

            Hitung SAW Sekarang

        </a>

    </div>

@endsection
