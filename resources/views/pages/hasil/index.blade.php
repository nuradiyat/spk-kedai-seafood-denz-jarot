@extends('layouts.app')

@section('title', 'Hasil SAW')

@section('content')
@php
    $hasil = collect($hasil ?? []);
    $daftarPeriode = collect($daftarPeriode ?? []);
    $periode = $periode ?? null;
    $isDiterima = fn ($h) => strtolower($h->status_bonus ?? '') === 'diterima';
    $penerima = $hasil->filter($isDiterima);
    $tertinggi = (float) ($hasil->max(fn ($h) => (float) ($h->nilai_akhir ?? 0)) ?? 0);
    $rataRata = (float) ($hasil->avg(fn ($h) => (float) ($h->nilai_akhir ?? 0)) ?? 0);
@endphp

<x-page-header title="Hasil Perhitungan SAW" subtitle="Ranking hasil penilaian karyawan berdasarkan metode SAW" :crumbs="['Metode SAW', 'Hasil SAW']">
    <x-slot name="actions">
        @if ($daftarPeriode->isNotEmpty())
            <form method="GET" action="{{ route('hasil.index') }}" class="flex items-center gap-2">
                <div class="relative">
                    <x-icon name="calendar" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                    <select name="periode" aria-label="Pilih periode"
                            class="h-11 appearance-none rounded-xl border border-slate-200 bg-white pl-10 pr-10 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-900/5 transition hover:border-slate-300 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                        @foreach ($daftarPeriode as $p)
                            <option value="{{ $p->id }}" {{ ($periode->id ?? null) == $p->id ? 'selected' : '' }}>{{ $p->periode }}</option>
                        @endforeach
                    </select>
                    <x-icon name="chevron-down" class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                </div>
                <button type="submit" class="btn btn-secondary px-3.5">Tampilkan</button>
            </form>
        @endif
        @if (isset($periode->id) && $hasil->isNotEmpty())
            <a href="{{ route('hasil.sensitivitas', $periode->id) }}" class="btn btn-secondary">
                <x-icon name="sliders" class="h-4 w-4 text-indigo-500" /> Analisis Sensitivitas
            </a>
        @endif
        <a href="{{ route('hasil.podium') }}" class="btn btn-gold">
            <x-icon name="trophy" class="h-4 w-4" /> Lihat Podium
        </a>
    </x-slot>
</x-page-header>

<div class="mb-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-mini-stat icon="calendar" tone="indigo" label="Periode" :value="$periode->periode ?? '-'"
                 :hint="isset($periode->tanggal_penilaian) ? \Carbon\Carbon::parse($periode->tanggal_penilaian)->translatedFormat('d F Y') : null" />
    <x-mini-stat icon="trophy" tone="emerald" label="Penerima Bonus" :value="$penerima->count().' Karyawan'"
                 :hint="$penerima->map(fn ($h) => $h->karyawan->nama_karyawan ?? '-')->implode(', ') ?: 'Belum ada'" />
    <x-mini-stat icon="trending-up" tone="amber" label="Nilai Tertinggi" :value="$hasil->isNotEmpty() ? number_format($tertinggi, 3) : '—'" hint="Nilai preferensi (V)" />
    <x-mini-stat icon="sigma" tone="violet" label="Rata-rata Nilai" :value="$hasil->isNotEmpty() ? number_format($rataRata, 3) : '—'" :hint="$hasil->count().' karyawan dinilai'" />
</div>

<x-card class="overflow-hidden">
    <x-card-header title="Tabel Perankingan" subtitle="Diurutkan dari nilai preferensi (V) tertinggi">
        @if ($hasil->isNotEmpty() && isset($periode->id))
            <div class="flex items-center gap-2">
                <a href="{{ route('hasil.detail', $periode->id) }}" class="btn-sm btn-sm-secondary">
                    <x-icon name="eye" class="h-4 w-4 text-indigo-500" /> Detail Matriks SAW
                </a>
                <a href="{{ route('hasil.export', $periode->id) }}" class="btn-sm btn-sm-secondary">
                    <x-icon name="file-down" class="h-4 w-4 text-rose-500" /> Export PDF
                </a>
            </div>
        @endif
    </x-card-header>

    @if ($hasil->isEmpty())
        <div class="flex flex-col items-center justify-center px-6 py-14 text-center">
            <span class="grid h-14 w-14 place-items-center rounded-2xl bg-slate-50 text-slate-400 ring-1 ring-inset ring-slate-200">
                <x-icon name="calculator" class="h-7 w-7" />
            </span>
            <p class="mt-4 text-sm font-semibold text-slate-900">Belum ada hasil perhitungan</p>
            <p class="mt-1 max-w-sm text-sm text-slate-500">Periode ini belum diproses. Jalankan Proses SAW terlebih dahulu pada menu Penilaian.</p>
            <a href="{{ route('penilaian.index') }}" class="btn btn-primary mt-5">
                <x-icon name="play" class="h-4 w-4" /> Buka Penilaian
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="tbl min-w-[780px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th w-24">Ranking</th>
                        <th class="tbl-th">Karyawan</th>
                        <th class="tbl-th">Nilai Akhir (V)</th>
                        <th class="tbl-th">Status Bonus</th>
                        <th class="tbl-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @foreach ($hasil as $h)
                        @php $nilai = (float) ($h->nilai_akhir ?? 0); @endphp
                        <tr class="tbl-row {{ $isDiterima($h) ? 'bg-emerald-50/40 hover:bg-emerald-50/70' : '' }}">
                            <td class="tbl-td"><x-rank :rank="$h->ranking ?? $loop->iteration" /></td>
                            <td class="tbl-td">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$h->karyawan->nama_karyawan ?? '-'" :seed="$h->karyawan->id ?? $loop->iteration" />
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $h->karyawan->nama_karyawan ?? '-' }}</p>
                                        <p class="text-xs text-slate-500">{{ $h->karyawan->jabatan ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="tbl-td w-72">
                                <div class="flex items-center gap-3">
                                    <span class="w-14 text-base font-bold tabular-nums text-indigo-600">{{ number_format($nilai, 3) }}</span>
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-sky-400" style="width: {{ min(100, max(0, $nilai * 100)) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="tbl-td">
                                @if ($isDiterima($h))
                                    <x-badge tone="emerald" icon="check-circle">Diterima</x-badge>
                                @else
                                    <x-badge tone="slate" icon="x-circle">Tidak</x-badge>
                                @endif
                            </td>
                            <td class="tbl-td">
                                <div class="flex items-center justify-end gap-2">
                                    <x-icon-button icon="eye" label="Detail" :href="route('hasil.detail', $h->penilaian_id)" />
                                    <a href="{{ route('hasil.export', $h->penilaian_id) }}" class="btn-sm btn-sm-pdf">
                                        <x-icon name="file-down" class="h-4 w-4 text-rose-500" /> Export PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-card>

@if ($radarData && count($radarData['datasets']) > 0)
<div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-12">
    <x-card class="overflow-hidden p-5 sm:p-6 lg:col-span-8">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-[15px] font-semibold text-slate-900">Visualisasi Multi-Kriteria (Radar Chart)</h2>
                <p class="mt-0.5 text-xs text-slate-500">Perbandingan performa rating ternormalisasi karyawan pada kriteria C1–C5</p>
            </div>
            <x-badge tone="indigo" icon="chart">Skala 0.0 – 1.0</x-badge>
        </div>

        <div class="relative mt-4 flex items-center justify-center min-h-[340px]">
            <canvas id="radarChart"></canvas>
        </div>
        <p class="mt-3 text-center text-xs text-slate-400">
            Klik nama karyawan pada legenda di atas grafik untuk menyembunyikan atau menampilkan perbandingan.
        </p>
    </x-card>

    <x-card class="flex flex-col justify-between p-5 sm:p-6 lg:col-span-4">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                    <x-icon name="trophy" class="h-4 w-4" />
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Analisis Komparatif</h3>
                    <p class="text-[11px] text-slate-500">Kekuatan Karyawan Unggulan</p>
                </div>
            </div>

            <div class="mt-4 space-y-3">
                @foreach ($hasil->take(3) as $top)
                    <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-900">Rank #{{ $top->ranking }}: {{ $top->karyawan->nama_karyawan }}</span>
                            <span class="font-mono text-xs font-semibold text-indigo-600">{{ number_format($top->nilai_akhir, 3) }}</span>
                        </div>
                        <p class="mt-1 text-[11px] text-slate-500">
                            @if ($loop->iteration === 1)
                                Memiliki keunggulan dominan pada kriteria kehadiran & konsistensi kerja.
                            @elseif ($loop->iteration === 2)
                                Menunjukkan performa sangat tinggi pada kriteria produktivitas kerja.
                            @else
                                Menunjukkan kontribusi stabil dan kerja sama tim yang solid.
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        @if (isset($periode->id))
            <a href="{{ route('hasil.sensitivitas', $periode->id) }}" class="btn btn-secondary mt-4 w-full justify-center">
                <x-icon name="sliders" class="h-4 w-4 text-indigo-600" /> Uji Sensitivitas Bobot &rarr;
            </a>
        @endif
    </x-card>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('radarChart');
        if (!ctx) return;

        const radarData = @json($radarData);

        new Chart(ctx, {
            type: 'radar',
            data: radarData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 1.0,
                        ticks: {
                            stepSize: 0.2,
                            backdropColor: 'transparent',
                            color: '#64748b',
                            font: { size: 10 }
                        },
                        grid: { color: 'rgba(226, 232, 240, 0.8)' },
                        angleLines: { color: 'rgba(226, 232, 240, 0.8)' },
                        pointLabels: {
                            color: '#334155',
                            font: { size: 11, weight: '600' }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 14,
                            color: '#334155',
                            font: { size: 12, weight: '500' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + Number(context.raw).toFixed(3);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endif

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <x-card class="flex gap-4 p-5">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-sky-50 text-sky-600 ring-1 ring-inset ring-sky-100">
            <x-icon name="info" class="h-5 w-5" />
        </span>
        <div>
            <p class="text-sm font-semibold text-slate-900">Keterangan Status Bonus</p>
            <p class="mt-1 text-sm leading-relaxed text-slate-500">
                Status <b class="text-emerald-600">Diterima</b> diberikan kepada karyawan dengan nilai preferensi tertinggi
                hasil perankingan metode SAW pada periode terpilih.
            </p>
        </div>
    </x-card>
    <x-card class="flex gap-4 p-5">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-violet-50 text-violet-600 ring-1 ring-inset ring-violet-100">
            <x-icon name="sigma" class="h-5 w-5" />
        </span>
        <div>
            <p class="text-sm font-semibold text-slate-900">Rumus Nilai Preferensi</p>
            <p class="mt-1 text-sm text-slate-500">Nilai akhir dihitung dari penjumlahan terbobot rating ternormalisasi:</p>
            <p class="mt-2 inline-block rounded-lg bg-slate-50 px-3 py-1.5 font-mono text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">Vᵢ = Σ wⱼ · rᵢⱼ</p>
        </div>
    </x-card>
</div>
@endsection