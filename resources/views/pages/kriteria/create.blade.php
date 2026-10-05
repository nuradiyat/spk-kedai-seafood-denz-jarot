@extends('layouts.app')

@section('title', 'Tambah Kriteria')

@section('content')
<x-page-header title="Tambah Kriteria" subtitle="Tambahkan kriteria baru untuk perhitungan metode SAW" :crumbs="['Master Data', 'Data Kriteria', 'Tambah']">
    <x-slot name="actions">
        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali
        </a>
    </x-slot>
</x-page-header>

<div class="grid gap-5 lg:grid-cols-3">
    <x-card class="lg:col-span-2">
        <x-card-header title="Informasi Kriteria" subtitle="Pastikan total bobot seluruh kriteria berjumlah 1.00 (100%)" icon="plus" />

        <form method="POST" action="{{ route('kriteria.store') }}" class="space-y-5 p-5 sm:p-6">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="kode" class="form-label">Kode Kriteria <span class="text-rose-500">*</span></label>
                    <input id="kode" name="kode" value="{{ old('kode') }}" required placeholder="Contoh: C1" class="form-input">
                    @error('kode') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="nama_kriteria" class="form-label">Nama Kriteria <span class="text-rose-500">*</span></label>
                    <input id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria') }}" required placeholder="Contoh: Kedisiplinan" class="form-input">
                    @error('nama_kriteria') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="bobot" class="form-label">Bobot Nilai (0.01 - 1.00) <span class="text-rose-500">*</span></label>
                    <input id="bobot" name="bobot" type="number" step="0.01" min="0" max="1" value="{{ old('bobot') }}" required placeholder="Contoh: 0.25" class="form-input">
                    @error('bobot') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <p class="form-label">Jenis Atribut</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-slate-300 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50/60 has-[:checked]:ring-4 has-[:checked]:ring-indigo-100">
                        <input type="radio" name="jenis" value="benefit" class="mt-0.5 h-4 w-4 accent-indigo-600"
                               {{ old('jenis', 'benefit') === 'benefit' ? 'checked' : '' }}>
                        <span>
                            <span class="block text-sm font-semibold text-slate-900">Benefit (Keuntungan)</span>
                            <span class="block text-xs text-slate-500">Semakin tinggi nilai, semakin baik penilaiannya.</span>
                        </span>
                    </label>

                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-slate-300 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50/60 has-[:checked]:ring-4 has-[:checked]:ring-indigo-100">
                        <input type="radio" name="jenis" value="cost" class="mt-0.5 h-4 w-4 accent-indigo-600"
                               {{ old('jenis') === 'cost' ? 'checked' : '' }}>
                        <span>
                            <span class="block text-sm font-semibold text-slate-900">Cost (Biaya)</span>
                            <span class="block text-xs text-slate-500">Semakin rendah nilai, semakin baik penilaiannya.</span>
                        </span>
                    </label>
                </div>
                @error('jenis') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <x-icon name="save" class="h-4 w-4" /> Simpan Kriteria
                </button>
            </div>
        </form>
    </x-card>

    <div class="space-y-5">
        <x-card class="p-6">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-sky-50 text-sky-600 ring-1 ring-inset ring-sky-100">
                <x-icon name="info" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-sm font-semibold text-slate-900">Aturan Bobot SAW</p>
            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                Pada metode Simple Additive Weighting, akumulasi seluruh bobot kriteria idealnya bernilai <b>1.00</b> (atau 100%).
            </p>
        </x-card>
    </div>
</div>
@endsection