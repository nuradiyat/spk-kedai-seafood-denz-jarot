@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<x-page-header title="Tambah Karyawan" subtitle="Tambahkan data karyawan baru ke dalam sistem" :crumbs="['Master Data', 'Data Karyawan', 'Tambah']">
    <x-slot name="actions">
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali
        </a>
    </x-slot>
</x-page-header>

<div class="grid gap-5 lg:grid-cols-3">
    <x-card class="lg:col-span-2">
        <x-card-header title="Informasi Karyawan" subtitle="Kolom bertanda * wajib diisi" icon="user-plus" />

        <form method="POST" action="{{ route('karyawan.store') }}" class="space-y-5 p-5 sm:p-6">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="nama_karyawan" class="form-label">Nama Karyawan <span class="text-rose-500">*</span></label>
                    <input id="nama_karyawan" name="nama_karyawan" value="{{ old('nama_karyawan') }}" required placeholder="Contoh: Imel Saputri" class="form-input">
                    @error('nama_karyawan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Staff Administrasi" class="form-input">
                    @error('jabatan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="tanggal_masuk" class="form-label">Tanggal Bergabung</label>
                    <input id="tanggal_masuk" name="tanggal_masuk" type="date" value="{{ old('tanggal_masuk') }}" class="form-input">
                    @error('tanggal_masuk') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <p class="form-label">Status Karyawan</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach (['aktif' => ['label' => 'Aktif', 'desc' => 'Diikutkan dalam penilaian bonus'], 'nonaktif' => ['label' => 'Nonaktif', 'desc' => 'Tidak diikutkan dalam penilaian']] as $val => $data)
                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-slate-300 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50/60 has-[:checked]:ring-4 has-[:checked]:ring-indigo-100">
                            <input type="radio" name="status" value="{{ $val }}" class="mt-0.5 h-4 w-4 accent-indigo-600"
                                   {{ old('status', 'aktif') === $val ? 'checked' : '' }}>
                            <span>
                                <span class="block text-sm font-semibold text-slate-900">{{ $data['label'] }}</span>
                                <span class="block text-xs text-slate-500">{{ $data['desc'] }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('status') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <x-icon name="save" class="h-4 w-4" /> Simpan Data
                </button>
            </div>
        </form>
    </x-card>

    <div class="space-y-5">
        <x-card class="p-6">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-sky-50 text-sky-600 ring-1 ring-inset ring-sky-100">
                <x-icon name="info" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-sm font-semibold text-slate-900">Panduan Pengisian</p>
            <ul class="mt-3 space-y-2.5 text-sm text-slate-500">
                @foreach ([
                    'Gunakan nama lengkap sesuai identitas karyawan.',
                    'Jabatan membantu identifikasi pada hasil perankingan.',
                    'Hanya karyawan berstatus Aktif yang akan diikutsertakan dalam penilaian.',
                    'Data dapat diubah kembali sewaktu-waktu melalui menu Edit.',
                ] as $tip)
                    <li class="flex gap-2.5">
                        <x-icon name="badge-check" class="mt-0.5 h-4 w-4 text-emerald-500" />
                        {{ $tip }}
                    </li>
                @endforeach
            </ul>
        </x-card>
    </div>
</div>
@endsection