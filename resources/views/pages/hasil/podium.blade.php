@extends('layouts.app')

@section('title', 'Podium Juara')

@section('content')
@php
    $hasil = collect($hasil ?? [])->values();
    $namaPeriode = $periode->periode ?? 'Periode Terakhir';
    $isDiterima = fn ($h) => strtolower($h->status_bonus ?? '') === 'diterima';
    $penerima = $hasil->filter($isDiterima);
    $lainnya = $hasil->slice(3);

    // Urutan tampil: juara 2 (kiri) - juara 1 (tengah) - juara 3 (kanan)
    $podium = [2 => $hasil->get(1), 1 => $hasil->get(0), 3 => $hasil->get(2)];
    $cfg = [
        1 => ['block' => 'h-40 sm:h-52 from-amber-300 to-amber-500', 'ring' => 'ring-amber-300', 'text' => 'text-amber-600',
              'chip' => 'bg-amber-50 text-amber-700 ring-amber-200', 'avatar' => 'h-20 w-20 text-2xl sm:h-24 sm:w-24 sm:text-3xl'],
        2 => ['block' => 'h-28 sm:h-36 from-slate-200 to-slate-400', 'ring' => 'ring-slate-300', 'text' => 'text-slate-600',
              'chip' => 'bg-slate-100 text-slate-700 ring-slate-200', 'avatar' => 'h-16 w-16 text-xl sm:h-20 sm:w-20 sm:text-2xl'],
        3 => ['block' => 'h-20 sm:h-28 from-orange-200 to-orange-400', 'ring' => 'ring-orange-300', 'text' => 'text-orange-600',
              'chip' => 'bg-orange-50 text-orange-700 ring-orange-200', 'avatar' => 'h-16 w-16 text-xl sm:h-20 sm:w-20 sm:text-2xl'],
    ];
    $confetti = [
        ['6%', '22%', 'bg-amber-400 rotate-12'], ['14%', '58%', 'bg-indigo-400 -rotate-12'], ['22%', '10%', 'bg-rose-400 rotate-45'],
        ['30%', '42%', 'bg-sky-300 -rotate-45'], ['70%', '9%', 'bg-violet-400 rotate-45'], ['79%', '38%', 'bg-emerald-400 -rotate-12'],
        ['89%', '16%', 'bg-amber-300 rotate-12'], ['94%', '55%', 'bg-sky-400 -rotate-45'],
    ];
@endphp

<x-page-header title="Podium Juara" :subtitle="'Tiga karyawan dengan nilai SAW tertinggi · '.$namaPeriode" :crumbs="['Metode SAW', 'Hasil SAW', 'Podium']">
    <x-slot name="actions">
        <a href="{{ route('hasil.index') }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Hasil
        </a>
    </x-slot>
</x-page-header>

<x-card class="relative overflow-hidden px-4 pt-8 sm:px-8 sm:pt-10">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(251,191,36,0.16),transparent_60%)]"></div>
    @foreach ($confetti as [$left, $top, $cls])
        <span class="pointer-events-none absolute h-3 w-1.5 rounded-sm opacity-70 {{ $cls }}" style="left: {{ $left }}; top: {{ $top }};"></span>
    @endforeach

    <div class="relative text-center">
        <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">
            <x-icon name="party" class="h-3.5 w-3.5" /> Selamat kepada para juara!
        </span>
        <h2 class="mt-3 text-xl font-bold text-slate-900 sm:text-2xl">Karyawan Terbaik {{ $namaPeriode }}</h2>
        <p class="mt-1 text-sm text-slate-500">Berdasarkan perhitungan Simple Additive Weighting (SAW)</p>
    </div>

    @if ($hasil->isEmpty())
        <p class="relative mx-auto my-12 max-w-sm text-center text-sm text-slate-500">Belum ada hasil perhitungan untuk ditampilkan.</p>
    @else
        <div class="relative mx-auto mt-10 grid max-w-3xl grid-cols-3 items-end gap-3 sm:gap-6">
            @foreach ($podium as $place => $h)
                @if ($h)
                    @php $c = $cfg[$place]; @endphp
                    <div class="flex flex-col items-center text-center">
                        @if ($place === 1)
                            <x-icon name="crown" class="mb-2 h-8 w-8 text-amber-400 drop-shadow-sm" fill="currentColor" />
                        @endif
                        <x-avatar :name="$h->karyawan->nama_karyawan ?? '-'" :seed="$h->karyawan->id ?? $place" size="none"
                                  class="ring-4 ring-offset-4 ring-offset-white {{ $c['ring'] }} {{ $c['avatar'] }}" />
                        <span class="mt-4 inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-bold ring-1 ring-inset {{ $c['chip'] }}">Juara {{ $place }}</span>
                        <p class="mt-2 text-sm font-bold text-slate-900 sm:text-base">{{ $h->karyawan->nama_karyawan ?? '-' }}</p>
                        <p class="hidden text-xs text-slate-500 sm:block">{{ $h->karyawan->jabatan ?? '' }}</p>
                        <p class="mt-1 text-lg font-extrabold tabular-nums sm:text-xl {{ $c['text'] }}">{{ number_format((float) ($h->nilai_akhir ?? 0), 3) }}</p>
                        <div class="relative mt-4 w-full overflow-hidden rounded-t-2xl bg-gradient-to-b {{ $c['block'] }}">
                            <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-white/35 to-transparent"></div>
                            <span class="relative block pt-4 text-4xl font-black text-white drop-shadow sm:text-5xl">{{ $place }}</span>
                        </div>
                    </div>
                @else
                    <div></div>
                @endif
            @endforeach
        </div>
    @endif
</x-card>

<div class="mt-5 grid gap-5 lg:grid-cols-3">
    <x-card class="overflow-hidden lg:col-span-2">
        <x-card-header title="Peringkat Selanjutnya" subtitle="Karyawan di luar tiga besar">
            <a href="{{ route('hasil.index') }}" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-50">
                Tabel lengkap <x-icon name="chevron-right" class="h-3.5 w-3.5" />
            </a>
        </x-card-header>
        <ul class="divide-y divide-slate-100">
            @forelse ($lainnya as $h)
                @php $nilai = (float) ($h->nilai_akhir ?? 0); @endphp
                <li class="flex items-center gap-4 px-5 py-4 transition-colors hover:bg-slate-50/70 sm:px-6">
                    <x-rank :rank="$h->ranking ?? $loop->iteration + 3" />
                    <x-avatar :name="$h->karyawan->nama_karyawan ?? '-'" :seed="$h->karyawan->id ?? $loop->iteration" />
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-slate-900">{{ $h->karyawan->nama_karyawan ?? '-' }}</p>
                        <p class="text-xs text-slate-500">{{ $h->karyawan->jabatan ?? '-' }}</p>
                    </div>
                    <div class="hidden w-40 sm:block">
                        <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-indigo-300" style="width: {{ min(100, max(0, $nilai * 100)) }}%"></div>
                        </div>
                    </div>
                    <span class="w-14 text-right font-bold tabular-nums text-slate-900">{{ number_format($nilai, 3) }}</span>
                </li>
            @empty
                <li class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada peringkat lainnya.</li>
            @endforelse
        </ul>
    </x-card>

    <x-card class="relative overflow-hidden p-6">
        <div class="pointer-events-none absolute -right-10 -top-10 h-36 w-36 rounded-full bg-emerald-100/70 blur-2xl"></div>
        <div class="relative">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-100">
                <x-icon name="trophy" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-sm font-medium text-slate-500">Penerima Bonus</p>
            <p class="text-2xl font-bold text-slate-900">{{ $penerima->map(fn ($h) => $h->karyawan->nama_karyawan ?? '-')->implode(', ') ?: '-' }}</p>
            @if ($penerima->isNotEmpty())
                <p class="mt-1 text-sm leading-relaxed text-slate-500">Selamat! {{ $penerima->first()->karyawan->nama_karyawan ?? '' }} memperoleh nilai preferensi tertinggi pada periode ini.</p>
            @endif
            <div class="mt-5 flex flex-col gap-2.5 sm:flex-row lg:flex-col xl:flex-row">
                @if ($penerima->isNotEmpty())
                    <a href="{{ route('hasil.export', $penerima->first()->penilaian_id) }}" class="btn btn-primary flex-1">
                        <x-icon name="file-down" class="h-4 w-4" /> Export PDF
                    </a>
                @endif
                <a href="{{ route('hasil.index') }}" class="btn btn-secondary flex-1">
                    <x-icon name="chart" class="h-4 w-4" /> Hasil SAW
                </a>
            </div>
        </div>
    </x-card>
</div>
@endsection