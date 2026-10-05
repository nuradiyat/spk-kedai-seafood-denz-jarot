@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<x-page-header :title="$karyawan->nama_karyawan" subtitle="Informasi detail data karyawan" :crumbs="['Master Data', 'Data Karyawan', 'Detail']">
    <x-slot name="actions">
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali
        </a>
        <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-primary">
            <x-icon name="pencil" class="h-4 w-4" /> Edit Karyawan
        </a>
    </x-slot>
</x-page-header>

<div class="grid gap-5 lg:grid-cols-3">
    <x-card class="p-6 lg:col-span-2">
        <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
            <x-avatar :name="$karyawan->nama_karyawan" :seed="$karyawan->id" size="xl" />
            <div>
                <h2 class="text-xl font-bold text-slate-900">{{ $karyawan->nama_karyawan }}</h2>
                <p class="text-sm text-slate-500">{{ $karyawan->jabatan ?: 'Staff / Karyawan' }}</p>
                <div class="mt-2">
                    <x-badge :tone="strtolower($karyawan->status) === 'aktif' ? 'emerald' : 'slate'" dot>
                        {{ ucfirst($karyawan->status) }}
                    </x-badge>
                </div>
            </div>
        </div>

        <div class="mt-6 grid gap-6 sm:grid-cols-2">
            <div>
                <p class="text-xs font-medium text-slate-400">ID Karyawan</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">#{{ str_pad($karyawan->id, 3, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400">Tanggal Bergabung</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $karyawan->tanggal_masuk ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('d F Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400">Ditambahkan Pada</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $karyawan->created_at ? $karyawan->created_at->translatedFormat('d F Y H:i') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400">Terakhir Diperbarui</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $karyawan->updated_at ? $karyawan->updated_at->translatedFormat('d F Y H:i') : '-' }}
                </p>
            </div>
        </div>
    </x-card>

    <div class="space-y-5">
        <x-card class="p-6">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                <x-icon name="chart" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-sm font-semibold text-slate-900">Status Penilaian</p>
            <p class="mt-1 text-sm text-slate-500">
                @if(strtolower($karyawan->status) === 'aktif')
                    Karyawan ini berstatus <span class="font-semibold text-emerald-600">Aktif</span> dan berhak diikutsertakan dalam pembobotan penilaian bonus SAW.
                @else
                    Karyawan ini berstatus <span class="font-semibold text-slate-600">Nonaktif</span> dan tidak akan muncul di form input penilaian baru.
                @endif
            </p>
        </x-card>
    </div>
</div>
@endsection