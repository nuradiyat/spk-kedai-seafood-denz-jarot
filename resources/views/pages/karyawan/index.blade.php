@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
@php
    $karyawan = $karyawans ?? collect();
    $rows = $karyawan instanceof \Illuminate\Contracts\Pagination\Paginator ? collect($karyawan->items()) : collect($karyawan);
    $total = $karyawan instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $karyawan->total() : $rows->count();
    $aktif = $rows->filter(fn ($k) => strtolower($k->status ?? 'aktif') === 'aktif')->count();
    $jumlahJabatan = $rows->pluck('jabatan')->filter()->unique()->count();
    $offset = $karyawan instanceof \Illuminate\Contracts\Pagination\Paginator ? ($karyawan->firstItem() ?? 1) - 1 : 0;
@endphp

<x-page-header title="Data Karyawan" subtitle="Kelola seluruh data karyawan perusahaan" :crumbs="['Master Data', 'Data Karyawan']">
    <x-slot name="actions">
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
            <x-icon name="user-plus" class="h-4 w-4" /> Tambah Karyawan
        </a>
    </x-slot>
</x-page-header>

<div class="mb-5 grid gap-4 sm:grid-cols-3">
    <x-mini-stat icon="users" tone="indigo" label="Total Karyawan" :value="$total" hint="Terdaftar di sistem" />
    <x-mini-stat icon="user-check" tone="emerald" label="Karyawan Aktif" :value="$aktif" hint="Diikutkan dalam penilaian" />
    <x-mini-stat icon="briefcase" tone="amber" label="Jumlah Jabatan" :value="$jumlahJabatan" hint="Posisi berbeda" />
</div>

<x-card class="overflow-hidden">
    <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="text-[15px] font-semibold text-slate-900">Daftar Karyawan</h2>
            <p class="mt-0.5 text-xs text-slate-500">{{ $rows->count() }} dari {{ $total }} karyawan ditampilkan</p>
        </div>
        <form method="GET" action="{{ route('karyawan.index') }}" class="relative block w-full sm:w-72">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau jabatan… (Enter)"
                   class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/60 pl-10 pr-3 text-sm text-slate-900 transition placeholder:text-slate-400 hover:border-slate-300 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100">
        </form>
    </div>

    @if ($rows->isEmpty())
        <div class="flex flex-col items-center justify-center px-6 py-14 text-center">
            <span class="grid h-14 w-14 place-items-center rounded-2xl bg-slate-50 text-slate-400 ring-1 ring-inset ring-slate-200">
                <x-icon name="search-x" class="h-7 w-7" />
            </span>
            <p class="mt-4 text-sm font-semibold text-slate-900">Karyawan tidak ditemukan</p>
            <p class="mt-1 max-w-sm text-sm text-slate-500">
                {{ request('search') ? 'Tidak ada karyawan yang cocok dengan kata kunci "'.request('search').'".' : 'Belum ada data karyawan. Tambahkan karyawan pertama.' }}
            </p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="tbl min-w-[760px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th w-16">No</th>
                        <th class="tbl-th">Karyawan</th>
                        <th class="tbl-th">Jabatan</th>
                        <th class="tbl-th">Bergabung</th>
                        <th class="tbl-th">Status</th>
                        <th class="tbl-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @foreach ($rows as $k)
                        @php $isAktif = strtolower($k->status ?? 'aktif') === 'aktif'; @endphp
                        <tr class="tbl-row">
                            <td class="tbl-td tabular-nums text-slate-400">{{ str_pad($offset + $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="tbl-td">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$k->nama_karyawan" :seed="$k->id" />
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $k->nama_karyawan }}</p>
                                        <p class="text-xs text-slate-500">ID Karyawan #{{ str_pad($k->id, 3, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="tbl-td">
                                <span class="inline-flex items-center gap-2 text-slate-600">
                                    <x-icon name="briefcase" class="h-4 w-4 text-slate-400" />
                                    {{ $k->jabatan ?: '-' }}
                                </span>
                            </td>
                            <td class="tbl-td text-slate-600">{{ ($k->tanggal_masuk ?? $k->created_at) ? \Carbon\Carbon::parse($k->tanggal_masuk ?? $k->created_at)->translatedFormat('d F Y') : '-' }}</td>
                            <td class="tbl-td">
                                <x-badge :tone="$isAktif ? 'emerald' : 'slate'" dot>{{ $isAktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                            </td>
                            <td class="tbl-td">
                                <div class="flex items-center justify-end gap-2">
                                    <x-icon-button icon="eye" label="Detail" :href="route('karyawan.show', $k->id)" />
                                    <x-icon-button icon="pencil" label="Edit" tone="amber" :href="route('karyawan.edit', $k->id)" />
                                    <x-delete-button :action="route('karyawan.destroy', $k->id)" :name="$k->nama_karyawan" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <x-table-footer :items="$karyawan" label="karyawan" />
</x-card>
@endsection