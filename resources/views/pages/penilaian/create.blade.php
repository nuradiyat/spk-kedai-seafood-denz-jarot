@extends('layouts.app')

@section('title', 'Input Penilaian')

@section('content')
@php
    $karyawan = collect($karyawans ?? $karyawan ?? []);
    $kriteria = collect($kriterias ?? $kriteria ?? []);
    $chipTones = [
        'bg-indigo-50 text-indigo-700 ring-indigo-600/15',
        'bg-sky-50 text-sky-700 ring-sky-600/15',
        'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
        'bg-amber-50 text-amber-700 ring-amber-600/20',
        'bg-rose-50 text-rose-700 ring-rose-600/15',
    ];
@endphp

<x-page-header title="Input Penilaian" subtitle="Masukkan nilai setiap karyawan berdasarkan kriteria metode SAW" :crumbs="['Metode SAW', 'Penilaian', 'Input']">
    <x-slot name="actions">
        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali
        </a>
    </x-slot>
</x-page-header>

<form method="POST" action="{{ route('penilaian.store') }}" class="space-y-5">
    @csrf

    <x-card>
        <x-card-header title="Informasi Periode" subtitle="Tentukan nama dan tanggal periode penilaian" icon="calendar" />
        <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">
            <div>
                <label for="periode" class="form-label">Nama Periode <span class="text-rose-500">*</span></label>
                <input id="periode" name="periode" value="{{ old('periode') }}" required placeholder="Contoh: Bulan Agustus 2026" class="form-input">
                @error('periode') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian <span class="text-rose-500">*</span></label>
                <input id="tanggal_penilaian" name="tanggal_penilaian" type="date" value="{{ old('tanggal_penilaian', now()->format('Y-m-d')) }}" required class="form-input">
                @error('tanggal_penilaian') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>
    </x-card>

    <x-card class="overflow-hidden">
        <x-card-header title="Matriks Penilaian" subtitle="Isi nilai 1–5 untuk setiap karyawan pada masing-masing kriteria (1=Sangat Kurang, 5=Sangat Baik)" icon="grid" />
        <div class="overflow-x-auto">
            <table class="tbl min-w-[880px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th">Karyawan</th>
                        @foreach ($kriteria as $c)
                            <th class="tbl-th text-center normal-case tracking-normal">
                                <span class="inline-grid h-6 min-w-9 place-items-center rounded-md px-1.5 text-[11px] font-bold ring-1 ring-inset {{ $chipTones[$loop->index % 5] }}">{{ $c->kode }}</span>
                                <span class="mt-1 block text-[11px] font-medium text-slate-600">{{ $c->nama_kriteria }}</span>
                                <span class="block text-[10px] font-semibold text-slate-400">Bobot {{ number_format((float) $c->bobot, 2) }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @forelse ($karyawan as $k)
                        <tr class="tbl-row">
                            <td class="tbl-td">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$k->nama_karyawan" :seed="$k->id" size="sm" />
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $k->nama_karyawan }}</p>
                                        <p class="text-xs text-slate-500">{{ $k->jabatan ?: '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            @foreach ($kriteria as $c)
                                <td class="px-2 py-3 last:pr-6">
                                    <select name="nilai[{{ $k->id }}][{{ $c->id }}]" required aria-label="Nilai {{ $c->kode }} untuk {{ $k->nama_karyawan }}"
                                            class="mx-auto block h-10 w-full max-w-[70px] cursor-pointer rounded-lg border border-slate-200 bg-white text-center text-sm font-semibold tabular-nums text-slate-900 transition hover:border-slate-300 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                                        <option value="" disabled {{ old('nilai.'.$k->id.'.'.$c->id) == null ? 'selected' : '' }}>-</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('nilai.'.$k->id.'.'.$c->id) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $kriteria->count() + 1 }}" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada karyawan aktif untuk dinilai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-4 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <p class="flex items-center gap-2 text-xs text-slate-500">
                <x-icon name="info" class="h-4 w-4 text-sky-500" /> Seluruh kolom wajib diisi dengan skala nilai 1–5 sebelum penilaian disimpan.
            </p>
            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <x-icon name="save" class="h-4 w-4" /> Simpan Penilaian
                </button>
            </div>
        </div>
    </x-card>
</form>
@endsection