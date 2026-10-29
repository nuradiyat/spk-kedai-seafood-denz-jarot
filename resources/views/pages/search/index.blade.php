@extends('layouts.app')

@section('title', 'Pencarian: ' . ($query ?: 'Semua'))

@section('content')
@php
    $userRole = auth()->user()->role ?? 'admin';
@endphp

<x-page-header
    title="Hasil Pencarian"
    :subtitle="$query !== '' ? 'Menampilkan hasil pencarian untuk kata kunci “' . $query . '” (' . $totalResults . ' data ditemukan)' : 'Ketik kata kunci pada kolom pencarian di atas untuk mencari karyawan, kriteria, atau periode penilaian.'"
    :crumbs="['Pencarian']">
</x-page-header>

@if ($query === '')
    <x-card class="flex flex-col items-center justify-center p-12 text-center">
        <span class="grid h-16 w-16 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
            <x-icon name="search" class="h-8 w-8" />
        </span>
        <h2 class="mt-4 text-base font-bold text-slate-900">Mulai Pencarian Terpadu</h2>
        <p class="mt-1 max-w-md text-sm text-slate-500">
            Anda dapat mencari nama karyawan, jabatan, kode kriteria (misal: <code>C1</code>), nama kriteria, atau nama periode penilaian (misal: <code>Mei 2026</code>).
        </p>
    </x-card>
@elseif ($totalResults === 0)
    <x-card class="flex flex-col items-center justify-center p-12 text-center">
        <span class="grid h-16 w-16 place-items-center rounded-2xl bg-rose-50 text-rose-500 ring-1 ring-inset ring-rose-100">
            <x-icon name="search-x" class="h-8 w-8" />
        </span>
        <h2 class="mt-4 text-base font-bold text-slate-900">Tidak Ada Hasil Ditemukan</h2>
        <p class="mt-1 max-w-md text-sm text-slate-500">
            Tidak ditemukan data karyawan, kriteria, maupun periode yang cocok dengan kata kunci &ldquo;<span class="font-semibold text-slate-700">{{ $query }}</span>&rdquo;.
        </p>
    </x-card>
@else
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- ============================ KARTU 1: KARYAWAN ============================ --}}
        <div class="flex flex-col">
            <x-card class="flex h-full flex-col">
                <x-card-header
                    title="Karyawan"
                    :subtitle="$karyawans->count() . ' karyawan cocok'"
                    icon="users">
                    @if ($userRole === 'admin')
                        <a href="{{ route('karyawan.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lihat Semua &rarr;</a>
                    @endif
                </x-card-header>

                <div class="flex-1 divide-y divide-slate-100">
                    @forelse ($karyawans as $k)
                        <div class="flex items-center justify-between gap-3 p-4 transition hover:bg-slate-50/70">
                            <div class="flex min-w-0 items-center gap-3">
                                <x-avatar :name="$k->nama_karyawan" :seed="$k->id" size="md" />
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $k->nama_karyawan }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $k->jabatan ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <x-badge :tone="strtolower($k->status) === 'aktif' ? 'emerald' : 'slate'" dot>
                                    {{ ucfirst($k->status) }}
                                </x-badge>
                                @if ($userRole === 'admin')
                                    <a href="{{ route('karyawan.edit', $k->id) }}" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-indigo-600" title="Edit Karyawan">
                                        <x-icon name="pencil" class="h-4 w-4" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center p-8 text-center text-slate-400">
                            <x-icon name="user-check" class="h-8 w-8 text-slate-300" />
                            <p class="mt-2 text-xs font-medium">Tidak ada data karyawan yang cocok</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>

        {{-- ============================ KARTU 2: KRITERIA ============================ --}}
        <div class="flex flex-col">
            <x-card class="flex h-full flex-col">
                <x-card-header
                    title="Kriteria SAW"
                    :subtitle="$kriterias->count() . ' kriteria cocok'"
                    icon="sliders">
                    @if ($userRole === 'admin')
                        <a href="{{ route('kriteria.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lihat Semua &rarr;</a>
                    @endif
                </x-card-header>

                <div class="flex-1 divide-y divide-slate-100">
                    @forelse ($kriterias as $c)
                        <div class="flex items-center justify-between gap-3 p-4 transition hover:bg-slate-50/70">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-indigo-50 font-bold text-xs text-indigo-600 ring-1 ring-inset ring-indigo-200">
                                    {{ $c->kode }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $c->nama_kriteria }}</p>
                                    <p class="text-xs text-slate-500">Bobot: <span class="font-semibold text-slate-700">{{ number_format($c->bobot, 2) }}</span></p>
                                </div>
                            </div>
                            <div class="shrink-0">
                                <x-badge :tone="strtolower($c->jenis) === 'benefit' ? 'emerald' : 'amber'">
                                    {{ ucfirst($c->jenis) }}
                                </x-badge>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center p-8 text-center text-slate-400">
                            <x-icon name="scale" class="h-8 w-8 text-slate-300" />
                            <p class="mt-2 text-xs font-medium">Tidak ada data kriteria yang cocok</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>

        {{-- ============================ KARTU 3: PERIODE PENILAIAN ============================ --}}
        <div class="flex flex-col">
            <x-card class="flex h-full flex-col">
                <x-card-header
                    title="Periode Penilaian"
                    :subtitle="$penilaians->count() . ' periode cocok'"
                    icon="calendar">
                    <a href="{{ route('hasil.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lihat Hasil &rarr;</a>
                </x-card-header>

                <div class="flex-1 divide-y divide-slate-100">
                    @forelse ($penilaians as $p)
                        <div class="flex flex-col gap-2 p-4 transition hover:bg-slate-50/70">
                            <div class="flex items-center justify-between gap-2">
                                <span class="truncate text-sm font-bold text-slate-900">{{ $p->periode }}</span>
                                @if ($p->hasilSaws->isNotEmpty())
                                    <x-badge tone="emerald" dot>SAW Diproses</x-badge>
                                @else
                                    <x-badge tone="amber" dot>Belum Dihitung</x-badge>
                                @endif
                            </div>
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span>{{ $p->tanggal_penilaian ? \Carbon\Carbon::parse($p->tanggal_penilaian)->translatedFormat('d F Y') : '-' }}</span>
                                <div class="flex items-center gap-2">
                                    @if ($p->hasilSaws->isNotEmpty())
                                        <a href="{{ route('hasil.detail', $p->id) }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Hasil SAW</a>
                                    @elseif ($userRole === 'admin')
                                        <a href="{{ route('penilaian.show', $p->id) }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Detail</a>
                                    @endif
                                    <span class="text-slate-300">&bull;</span>
                                    <a href="{{ route('riwayat.detail', $p->id) }}" class="font-semibold text-slate-600 hover:text-slate-900">Riwayat</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center p-8 text-center text-slate-400">
                            <x-icon name="calendar-check" class="h-8 w-8 text-slate-300" />
                            <p class="mt-2 text-xs font-medium">Tidak ada periode yang cocok</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
@endif
@endsection
