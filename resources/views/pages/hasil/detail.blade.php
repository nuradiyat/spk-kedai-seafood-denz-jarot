{{--
================================================================
pages/hasil/detail.blade.php
Detail hasil SAW lengkap: semua tahapan + ranking final.
Controller : HasilSawController@detail
Route      : GET /hasil/{penilaian}/detail → hasil.detail
================================================================
--}}
@extends('layouts.app')

@section('title', 'Detail Hasil SAW — ' . $penilaian->periode_label)
@section('page-title', 'Detail Hasil SAW')
@section('page-subtitle', $penilaian->periode_label . ' — Perhitungan lengkap metode SAW')

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('hasil.index') }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">{{ $penilaian->judul }}</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('hasil.export', $penilaian->id) }}"
                class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-600
                  text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors no-print">
                <i class="fas fa-download text-xs"></i> Export
            </a>
            <a href="{{ route('hasil.index') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
                  text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
                  hover:shadow-md transition-all no-print">
                <i class="fas fa-list text-xs"></i> Semua Hasil
            </a>
        </div>
    </div>

    {{-- ===== PODIUM TOP 3 ===== --}}
    @include('pages.hasil.podium', ['hasilSaws' => $hasilSaws])

    {{-- ===== STEPPER NAVIGASI TAHAPAN ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-4 mb-5 overflow-x-auto no-print">
        <div class="flex items-center gap-0 min-w-max">
            @php
                $steps = [
                    [
                        'num' => 1,
                        'label' => 'Matriks Keputusan',
                        'sub' => 'Nilai mentah (X)',
                        'route' => 'penilaian.matriks',
                    ],
                    [
                        'num' => 2,
                        'label' => 'Normalisasi',
                        'sub' => 'r(ij) = x(ij)/max',
                        'route' => 'penilaian.normalisasi',
                    ],
                    ['num' => 3, 'label' => 'Pembobotan', 'sub' => 'w(j) × r(ij)', 'route' => 'penilaian.ranking'],
                    ['num' => 4, 'label' => 'Nilai Akhir Vi', 'sub' => 'V(i) = Σ(w×r)', 'route' => 'penilaian.ranking'],
                ];
            @endphp
            @foreach ($steps as $idx => $step)
                <a href="{{ route($step['route'], $penilaian->id) }}"
                    class="flex items-center gap-2.5 shrink-0 hover:opacity-75 transition-opacity">
                    <div
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-teal to-teal-600
                        flex items-center justify-center font-heading font-bold text-white text-sm shrink-0">
                        {{ $step['num'] }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-xs font-semibold text-ocean leading-tight">{{ $step['label'] }}</p>
                        <p class="text-[10px] text-slate-400 font-mono">{{ $step['sub'] }}</p>
                    </div>
                </a>
                @if ($idx < count($steps) - 1)
                    <div class="flex-1 min-w-8 h-0.5 bg-gradient-to-r from-teal/60 to-teal/10 rounded-full mx-3"></div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- ===== STRIP BOBOT KRITERIA ===== --}}
    <div class="flex flex-wrap items-center gap-2 bg-white border border-slate-200 rounded-2xl p-4 mb-5">
        @foreach ($kriterias as $k)
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                <span class="font-heading font-bold text-ocean text-xs">{{ $k->kode }}</span>
                <span class="text-slate-400 text-xs">{{ $k->nama }}</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-lg bg-teal-bg text-teal-700 border border-teal-200">
                    W={{ $k->bobot }}
                </span>
            </div>
        @endforeach
        <div class="ml-auto text-xs font-bold text-teal">Σ W = 1.00 ✓</div>
    </div>

    {{-- ===== TAHAP 1: MATRIKS KEPUTUSAN ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        <div class="flex items-start gap-3 px-5 py-4 border-b border-slate-100">
            <span
                class="bg-blue-50 text-blue-700 border border-blue-200 text-[11px] font-bold px-3 py-1 rounded-full whitespace-nowrap mt-0.5">Tahap
                1</span>
            <div>
                <h3 class="font-heading font-bold text-ocean text-[15px]">Matriks Keputusan (X)</h3>
                <p class="text-slate-400 text-xs mt-0.5">Nilai asli setiap karyawan per kriteria. Skala 1–5. Hijau = nilai
                    tertinggi di kolom.</p>
            </div>
        </div>
        <div class="overflow-x-auto p-5">
            <table class="w-full text-sm border-collapse" style="min-width:500px">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3 bg-slate-50 border border-slate-200 min-w-[140px]">
                            Karyawan</th>
                        @foreach ($kriterias as $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3 bg-slate-50 border border-slate-200">
                                {{ $k->kode }}<br><span
                                    class="font-normal normal-case text-[10px] tracking-normal">{{ $k->nama }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasilSaws as $h)
                        <tr class="{{ $loop->odd ? 'bg-slate-50/40' : 'bg-white' }}">
                            <td class="px-4 py-3 border border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 text-white text-[10px] font-bold font-heading bg-gradient-to-br {{ $h->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($h->karyawan->nama, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $h->karyawan->nama }}</span>
                                </div>
                            </td>
                            @foreach ($kriterias as $k)
                                @php $v = $h->detail_normalisasi[$k->id]['nilai_asli'] ?? ($matriksX[$h->karyawan_id][$k->id] ?? 0); @endphp
                                <td
                                    class="px-4 py-3 border border-slate-200 text-center font-semibold
                               {{ $v == ($maxPerKriteria[$k->id] ?? 0) ? 'cell-best' : 'text-slate-700' }}">
                                    {{ $v }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                <tfoot>
                    <tr class="bg-ocean/5">
                        <td class="px-4 py-2.5 border border-slate-200 font-bold text-ocean text-xs">Max(X<sub>j</sub>)</td>
                        @foreach ($kriterias as $k)
                            <td
                                class="px-4 py-2.5 border border-slate-200 text-center font-bold text-teal-700 bg-teal-bg/60 text-xs">
                                {{ $maxPerKriteria[$k->id] ?? '—' }}</td>
                        @endforeach
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== TAHAP 2: NORMALISASI ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        <div class="flex items-start gap-3 px-5 py-4 border-b border-slate-100">
            <span
                class="bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold px-3 py-1 rounded-full whitespace-nowrap mt-0.5">Tahap
                2</span>
            <div>
                <h3 class="font-heading font-bold text-ocean text-[15px]">Matriks Normalisasi (R)</h3>
                <p class="text-slate-400 text-xs mt-0.5">r<sub>ij</sub> = x<sub>ij</sub> ÷ Max(x<sub>ij</sub>) untuk
                    benefit. Nilai hijau = r = 1.00 (terbaik).</p>
            </div>
        </div>
        <div class="overflow-x-auto p-5">
            <table class="w-full text-sm border-collapse" style="min-width:520px">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3 bg-slate-50 border border-slate-200 min-w-[140px]">
                            Karyawan</th>
                        @foreach ($kriterias as $idx => $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3 bg-slate-50 border border-slate-200">
                                r<sub>i{{ $idx + 1 }}</sub><br><span
                                    class="font-normal normal-case text-[10px] tracking-normal">{{ $k->kode }}÷{{ $maxPerKriteria[$k->id] ?? '?' }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasilSaws as $h)
                        <tr class="{{ $loop->odd ? 'bg-slate-50/40' : 'bg-white' }}">
                            <td class="px-4 py-3 border border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 text-white text-[10px] font-bold font-heading bg-gradient-to-br {{ $h->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($h->karyawan->nama, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $h->karyawan->nama }}</span>
                                </div>
                            </td>
                            @foreach ($kriterias as $k)
                                @php
                                    $detail = $h->detail_normalisasi[$k->id] ?? [];
                                    $rij = $detail['normalisasi'] ?? 0;
                                @endphp
                                <td
                                    class="px-3 py-3 border border-slate-200 text-center text-[12px] {{ $rij >= 1.0 ? 'cell-best' : 'text-slate-700' }}">
                                    <div class="font-mono font-semibold">{{ number_format($rij, 4) }}</div>
                                    <div class="text-[10px] text-slate-400">
                                        {{ $detail['nilai_asli'] ?? 0 }}/{{ $maxPerKriteria[$k->id] ?? '?' }}</div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== TAHAP 3 & 4: PEMBOBOTAN + RANKING ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        <div class="flex items-start gap-3 px-5 py-4 border-b border-slate-100">
            <span
                class="bg-red-50 text-red-600 border border-red-200 text-[11px] font-bold px-3 py-1 rounded-full whitespace-nowrap mt-0.5">Tahap
                3 & 4</span>
            <div>
                <h3 class="font-heading font-bold text-ocean text-[15px]">Pembobotan &amp; Nilai Akhir V<sub>i</sub></h3>
                <p class="text-slate-400 text-xs mt-0.5">V<sub>i</sub> = Σ(w<sub>j</sub> × r<sub>ij</sub>). Diurutkan dari
                    tertinggi ke terendah.</p>
            </div>
        </div>
        <div class="overflow-x-auto p-5">
            <table class="w-full text-sm border-collapse" style="min-width:620px">
                <thead>
                    <tr>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 bg-slate-50 border border-slate-200">
                            Rank</th>
                        <th
                            class="text-left   text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3.5 bg-slate-50 border border-slate-200 min-w-[140px]">
                            Karyawan</th>
                        @foreach ($kriterias as $idx => $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 bg-slate-50 border border-slate-200">
                                w<sub>{{ $idx + 1 }}</sub>·r<sub>{{ $idx + 1 }}</sub><br><span
                                    class="font-normal normal-case text-[10px] tracking-normal">{{ $k->kode }}</span>
                            </th>
                        @endforeach
                        <th
                            class="text-center text-[11px] font-bold text-teal-700 uppercase tracking-wide px-4 py-3.5 bg-teal-bg border border-teal-200 min-w-[80px]">
                            V<sub>i</sub></th>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3.5 bg-slate-50 border border-slate-200">
                            Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rankBg = [1 => 'bg-yellow-50/40', 2 => 'bg-slate-50/20', 3 => 'bg-orange-50/30'];
                        $rankBadge = [
                            1 => 'bg-yellow-100 text-yellow-700',
                            2 => 'bg-slate-200 text-slate-600',
                            3 => 'bg-orange-100 text-orange-600',
                        ];
                    @endphp
                    @foreach ($hasilSaws as $h)
                        <tr class="{{ $rankBg[$h->ranking] ?? '' }}">
                            <td class="px-3 py-3.5 border border-slate-200 text-center">
                                <span
                                    class="{{ $rankBadge[$h->ranking] ?? 'bg-slate-100 text-slate-400' }}
                                     inline-flex items-center justify-center w-7 h-7 rounded-lg font-heading font-bold text-sm">
                                    {{ $h->ranking }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 border border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 text-white text-[10px] font-bold font-heading bg-gradient-to-br {{ $h->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($h->karyawan->nama, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $h->karyawan->nama }}</span>
                                </div>
                            </td>
                            @foreach ($kriterias as $k)
                                <td
                                    class="px-3 py-3.5 border border-slate-200 text-center font-mono font-medium text-xs text-slate-700">
                                    {{ number_format($h->detail_normalisasi[$k->id]['hasil_bobot'] ?? 0, 4) }}
                                </td>
                            @endforeach
                            <td
                                class="px-4 py-3.5 border border-teal-200 text-center bg-teal-bg/60 font-heading font-bold text-base
                               {{ $h->ranking <= 2 ? 'text-teal-800' : ($h->ranking <= 4 ? 'text-teal-700' : 'text-slate-500') }}">
                                {{ number_format($h->nilai_akhir, 4) }}
                            </td>
                            <td class="px-4 py-3.5 border border-slate-200 text-center">
                                @if ($h->penerima_bonus)
                                    @include('components.badges.status', ['status' => 'bonus'])
                                @elseif($h->ranking == 5)
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

        {{-- Formula box --}}
        <div class="mx-5 mb-5 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600">
            <span class="font-bold text-ocean mr-2">Formula:</span>
            V<sub>i</sub> =
            @foreach ($kriterias as $idx => $k)
                ({{ $k->bobot }} × r<sub>i{{ $idx + 1 }}</sub>)
                {{ !$loop->last ? ' + ' : '' }}
            @endforeach
        </div>

        {{-- Kesimpulan --}}
        <div class="mx-5 mb-5 bg-gradient-to-br from-slate-50 to-teal-bg/30 border border-teal-100 rounded-2xl p-5">
            <h4 class="font-heading font-bold text-ocean text-sm mb-4">
                <i class="fas fa-check-circle text-teal mr-2"></i>Kesimpulan — Penerima Bonus
                {{ $penilaian->periode_label }}
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @php
                    $rankIcon = [
                        1 => 'bg-yellow-100 text-yellow-700',
                        2 => 'bg-slate-200 text-slate-600',
                        3 => 'bg-orange-100 text-orange-600',
                        4 => 'bg-teal-bg text-teal-700',
                    ];
                    $medalIcon = [1 => '🥇', 2 => '🥈', 3 => '🥉', 4 => '🏅'];
                @endphp
                @foreach ($hasilSaws->where('penerima_bonus', true) as $h)
                    <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3">
                        <span class="text-xl shrink-0">{{ $medalIcon[$h->ranking] ?? '🏅' }}</span>
                        <span
                            class="{{ $rankIcon[$h->ranking] ?? 'bg-slate-100 text-slate-500' }}
                             inline-flex items-center justify-center w-6 h-6 rounded-lg font-heading font-bold text-xs shrink-0">
                            {{ $h->ranking }}
                        </span>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-800 text-sm truncate">{{ $h->karyawan->nama }}</p>
                            <p class="text-xs text-slate-400">
                                V<sub>i</sub> = <span
                                    class="font-mono font-bold text-teal-600">{{ number_format($h->nilai_akhir, 4) }}</span>
                                @if ($h->jumlah_bonus > 0)
                                    · Bonus: <span class="font-bold text-teal-600">Rp
                                        {{ number_format($h->jumlah_bonus, 0, ',', '.') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
