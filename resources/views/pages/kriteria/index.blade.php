@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')
@php
    $kriteria = collect($kriterias ?? $kriteria ?? []);
    $totalBobot = (float) $kriteria->sum('bobot');
    $bobotValid = abs($totalBobot - 1) < 0.0001;
    $isBenefit = fn ($k) => strtolower($k->jenis ?? 'benefit') === 'benefit';
    $jumlahBenefit = $kriteria->filter($isBenefit)->count();
    $jumlahCost = $kriteria->count() - $jumlahBenefit;

    $barTones = ['bg-indigo-500', 'bg-sky-500', 'bg-emerald-500', 'bg-amber-400', 'bg-rose-400'];
    $chipTones = [
        'bg-indigo-50 text-indigo-700 ring-indigo-600/15',
        'bg-sky-50 text-sky-700 ring-sky-600/15',
        'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
        'bg-amber-50 text-amber-700 ring-amber-600/20',
        'bg-rose-50 text-rose-700 ring-rose-600/15',
    ];
@endphp

<x-page-header title="Data Kriteria" subtitle="Kelola data kriteria dan bobot penilaian metode SAW" :crumbs="['Master Data', 'Data Kriteria']">
    <x-slot name="actions">
        <a href="{{ route('kriteria.create') }}" class="btn btn-primary">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Kriteria
        </a>
    </x-slot>
</x-page-header>

<div class="grid gap-5 lg:grid-cols-3">
    {{-- Komposisi bobot --}}
    <x-card class="p-5 sm:p-6 lg:col-span-2">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-[15px] font-semibold text-slate-900">Komposisi Bobot Kriteria</h2>
                <p class="mt-0.5 text-xs text-slate-500">Total seluruh bobot harus bernilai 1.00 (100%)</p>
            </div>
            @if ($bobotValid)
                <x-badge tone="emerald" icon="check-circle">Bobot valid · {{ number_format($totalBobot, 2) }}</x-badge>
            @else
                <x-badge tone="rose" icon="x-circle">Bobot belum 1.00 ({{ number_format($totalBobot, 2) }})</x-badge>
            @endif
        </div>

        <div class="mt-5 flex h-4 gap-1 overflow-hidden rounded-full bg-slate-100">
            @foreach ($kriteria as $k)
                <div title="{{ $k->kode }} · {{ $k->nama_kriteria }}"
                     class="h-full first:rounded-l-full last:rounded-r-full {{ $barTones[$loop->index % 5] }}"
                     style="width: {{ (float) $k->bobot * 100 }}%"></div>
            @endforeach
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-5">
            @foreach ($kriteria as $k)
                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full {{ $barTones[$loop->index % 5] }}"></span>
                        <span class="text-xs font-bold text-slate-500">{{ $k->kode }}</span>
                    </div>
                    <p class="mt-1.5 text-xl font-bold tabular-nums text-slate-900">{{ round((float) $k->bobot * 100) }}%</p>
                    <p class="truncate text-[11px] text-slate-500" title="{{ $k->nama_kriteria }}">{{ $k->nama_kriteria }}</p>
                </div>
            @endforeach
        </div>
    </x-card>

    {{-- Ringkasan --}}
    <x-card class="p-5 sm:p-6">
        <h2 class="text-[15px] font-semibold text-slate-900">Ringkasan</h2>
        <dl class="mt-4 space-y-3 text-sm">
            <div class="flex items-center justify-between">
                <dt class="text-slate-500">Jumlah Kriteria</dt>
                <dd class="font-semibold text-slate-900">{{ $kriteria->count() }} kriteria</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-slate-500">Total Bobot</dt>
                <dd class="font-semibold tabular-nums text-slate-900">{{ number_format($totalBobot, 2) }}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-slate-500">Kriteria Benefit</dt>
                <dd><x-badge tone="emerald" icon="trending-up">{{ $jumlahBenefit }}</x-badge></dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-slate-500">Kriteria Cost</dt>
                <dd><x-badge tone="rose" icon="trending-down">{{ $jumlahCost }}</x-badge></dd>
            </div>
        </dl>
        <div class="mt-5 rounded-xl bg-indigo-50/70 p-4 text-xs leading-relaxed text-indigo-900/80 ring-1 ring-inset ring-indigo-100">
            <p class="mb-1 flex items-center gap-1.5 font-semibold text-indigo-900">
                <x-icon name="info" class="h-4 w-4 text-indigo-600" /> Keterangan Jenis
            </p>
            <b>Benefit</b>: semakin besar nilai semakin baik. <b>Cost</b>: semakin kecil nilai semakin baik.
        </div>
    </x-card>
</div>

{{-- Tabel --}}
<x-card class="mt-5 overflow-hidden">
    <x-card-header title="Daftar Kriteria" :subtitle="$kriteria->count().' kriteria digunakan dalam perhitungan SAW'" />
    <div class="overflow-x-auto">
        <table class="tbl min-w-[720px]">
            <thead class="tbl-head">
                <tr>
                    <th class="tbl-th w-24">Kode</th>
                    <th class="tbl-th">Nama Kriteria</th>
                    <th class="tbl-th">Bobot</th>
                    <th class="tbl-th">Jenis</th>
                    <th class="tbl-th text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="tbl-body">
                @forelse ($kriteria as $k)
                    <tr class="tbl-row">
                        <td class="tbl-td">
                            <span class="inline-grid h-9 w-11 place-items-center rounded-lg text-xs font-bold ring-1 ring-inset {{ $chipTones[$loop->index % 5] }}">{{ $k->kode }}</span>
                        </td>
                        <td class="tbl-td">
                            <p class="font-semibold text-slate-900">{{ $k->nama_kriteria }}</p>
                        </td>
                        <td class="tbl-td">
                            <div class="flex items-baseline gap-2">
                                <span class="text-base font-bold tabular-nums text-slate-900">{{ number_format((float) $k->bobot, 2) }}</span>
                                <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[11px] font-semibold text-slate-500">{{ round((float) $k->bobot * 100) }}%</span>
                            </div>
                        </td>
                        <td class="tbl-td">
                            @if ($isBenefit($k))
                                <x-badge tone="emerald" icon="trending-up">Benefit</x-badge>
                            @else
                                <x-badge tone="rose" icon="trending-down">Cost</x-badge>
                            @endif
                        </td>
                        <td class="tbl-td">
                            <div class="flex items-center justify-end gap-2">
                                <x-icon-button icon="pencil" label="Edit" tone="amber" :href="route('kriteria.edit', $k->id)" />
                                <x-delete-button :action="route('kriteria.destroy', $k->id)" :name="$k->kode" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada data kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection