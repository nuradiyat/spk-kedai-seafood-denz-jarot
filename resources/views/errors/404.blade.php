@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="flex min-h-[60vh] flex-col items-center justify-center text-center">
    <span class="grid h-16 w-16 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
        <x-icon name="search-x" class="h-8 w-8" />
    </span>
    <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900">404</h1>
    <p class="mt-2 text-base font-semibold text-slate-800">Halaman Tidak Ditemukan</p>
    <p class="mt-1 max-w-sm text-sm text-slate-500">
        Halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau tautan yang Anda masukkan salah.
    </p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-6">
        <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Dashboard
    </a>
</div>
@endsection
