@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('content')
@php
    $penilaian = collect($penilaians ?? $penilaian ?? []);
    $rows = $penilaian instanceof \Illuminate\Contracts\Pagination\Paginator ? collect($penilaian->items()) : collect($penilaian);
    $sudah = $rows->filter(fn ($p) => $p->hasilSaws && $p->hasilSaws->count() > 0)->count();
    $offset = $penilaian instanceof \Illuminate\Contracts\Pagination\Paginator ? ($penilaian->firstItem() ?? 1) - 1 : 0;
@endphp

<x-page-header title="Data Penilaian" subtitle="Kelola proses penilaian karyawan menggunakan metode SAW" :crumbs="['Metode SAW', 'Penilaian']">
    <x-slot name="actions">
        <a href="{{ route('penilaian.create') }}" class="btn btn-primary">
            <x-icon name="plus" class="h-4 w-4" /> Input Penilaian
        </a>
    </x-slot>
</x-page-header>

<div class="mb-5 grid gap-4 sm:grid-cols-3">
    <x-mini-stat icon="clipboard" tone="indigo" label="Total Periode" :value="$rows->count()" hint="Periode penilaian dibuat" />
    <x-mini-stat icon="check-circle" tone="emerald" label="Sudah Diproses" :value="$sudah" hint="Hasil SAW sudah tersedia" />
    <x-mini-stat icon="clock" tone="amber" label="Belum Diproses" :value="$rows->count() - $sudah" hint="Menunggu Proses SAW" />
</div>

<x-card class="overflow-hidden">
    <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="text-[15px] font-semibold text-slate-900">Daftar Periode Penilaian</h2>
            <p class="mt-0.5 text-xs text-slate-500">Jalankan Proses SAW untuk menghitung ranking pada setiap periode</p>
        </div>
        <form method="GET" action="{{ route('penilaian.index') }}" class="relative block w-full sm:w-72">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama periode penilaian..."
                   class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/60 pl-10 pr-3 text-sm text-slate-900 transition placeholder:text-slate-400 hover:border-slate-300 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100">
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="tbl min-w-[820px]">
            <thead class="tbl-head">
                <tr>
                    <th class="tbl-th w-16">No</th>
                    <th class="tbl-th">Periode</th>
                    <th class="tbl-th">Tanggal</th>
                    <th class="tbl-th">Admin</th>
                    <th class="tbl-th">Status</th>
                    <th class="tbl-th text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="tbl-body">
                @forelse ($rows as $p)
                    @php
                        $diproses = $p->hasilSaws && $p->hasilSaws->count() > 0;
                        $admin = $p->user->name ?? 'Admin';
                    @endphp
                    <tr class="tbl-row">
                        <td class="tbl-td tabular-nums text-slate-400">{{ str_pad($offset + $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="tbl-td">
                            <div class="flex items-center gap-3">
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                                    <x-icon name="calendar" class="h-5 w-5" />
                                </span>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $p->periode }}</p>
                                    <p class="text-xs text-slate-500">Kode #PNL-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="tbl-td text-slate-600">{{ \Carbon\Carbon::parse($p->tanggal_penilaian ?? $p->created_at)->translatedFormat('d F Y') }}</td>
                        <td class="tbl-td">
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-50 py-1 pl-1 pr-3 ring-1 ring-inset ring-slate-200/70">
                                <span class="grid h-6 w-6 place-items-center rounded-full bg-slate-800 text-[10px] font-bold text-white">{{ mb_strtoupper(mb_substr($admin, 0, 1)) }}</span>
                                <span class="text-xs font-semibold text-slate-700">{{ $admin }}</span>
                            </span>
                        </td>
                        <td class="tbl-td">
                            @if ($diproses)
                                <x-badge tone="emerald" dot>Sudah Diproses</x-badge>
                            @else
                                <x-badge tone="amber" dot>Belum Diproses</x-badge>
                            @endif
                        </td>
                        <td class="tbl-td">
                            <div class="flex items-center justify-end gap-2">
                                <x-icon-button icon="eye" label="Detail penilaian" :href="route('penilaian.show', $p->id)" />
                                <form method="POST" action="{{ route('hasil.proses', $p->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-sm {{ $diproses ? 'btn-sm-secondary' : 'btn-sm-primary' }}">
                                        <x-icon name="play" class="h-3.5 w-3.5" /> Proses SAW
                                    </button>
                                </form>
                                <x-delete-button :action="route('penilaian.destroy', $p->id)" :name="$p->periode" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-slate-50 ring-1 ring-inset ring-slate-200">
                                    <x-icon name="search-x" class="h-6 w-6" />
                                </span>
                                <p class="mt-3 text-sm font-semibold text-slate-900">Periode tidak ditemukan</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ request('search') ? 'Tidak ada periode penilaian yang cocok dengan kata kunci "'.request('search').'".' : 'Belum ada data penilaian.' }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>

<div class="mt-5 flex gap-3 rounded-2xl border border-sky-200/70 bg-sky-50/70 p-4 sm:p-5">
    <x-icon name="info" class="mt-0.5 h-5 w-5 text-sky-600" />
    <div class="text-sm">
        <p class="font-semibold text-sky-900">Tips</p>
        <p class="mt-0.5 leading-relaxed text-sky-800/80">
            Pastikan seluruh karyawan sudah dinilai pada semua kriteria sebelum menjalankan <b>Proses SAW</b>.
            Hasil perhitungan dapat dilihat pada menu <b>Hasil SAW</b> dan tersimpan otomatis di <b>Riwayat</b>.
        </p>
    </div>
</div>
@endsection