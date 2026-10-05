@extends('layouts.app')

@section('title', 'Detail Riwayat')

@section('content')
<x-page-header :title="'Detail Riwayat · '.$penilaian->periode" subtitle="Histori hasil perhitungan metode SAW yang tersimpan" :crumbs="['Metode SAW', 'Riwayat', 'Detail']">
    <x-slot name="actions">
        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Riwayat
        </a>
        <a href="{{ route('riwayat.export', $penilaian->id) }}" class="btn btn-primary">
            <x-icon name="file-down" class="h-4 w-4 text-white" /> Export PDF
        </a>
    </x-slot>
</x-page-header>

<div class="grid gap-5 lg:grid-cols-3">
    <x-card class="p-6">
        <div class="flex items-center gap-3">
            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                <x-icon name="history" class="h-6 w-6" />
            </span>
            <div>
                <h2 class="text-base font-bold text-slate-900">{{ $penilaian->periode }}</h2>
                <p class="text-xs text-slate-500">Histori Penilaian Terproses</p>
            </div>
        </div>

        <dl class="mt-6 divide-y divide-slate-100 text-sm">
            <div class="flex items-center justify-between py-2.5">
                <dt class="text-slate-500">Tanggal Penilaian</dt>
                <dd class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->translatedFormat('d F Y') }}</dd>
            </div>
            <div class="flex items-center justify-between py-2.5">
                <dt class="text-slate-500">Admin</dt>
                <dd class="font-semibold text-slate-900">{{ $penilaian->user->name ?? 'Admin' }}</dd>
            </div>
            <div class="flex items-center justify-between py-2.5">
                <dt class="text-slate-500">Total Karyawan</dt>
                <dd class="font-semibold text-slate-900">{{ $penilaian->hasilSaws->count() }} orang</dd>
            </div>
            <div class="flex items-center justify-between py-2.5">
                <dt class="text-slate-500">Penerima Bonus</dt>
                <dd class="font-semibold text-emerald-600">{{ $penilaian->hasilSaws->where('status_bonus', 'Diterima')->count() }} orang</dd>
            </div>
        </dl>
    </x-card>

    <x-card class="overflow-hidden lg:col-span-2">
        <x-card-header title="Ranking Hasil SAW" subtitle="Peringkat karyawan pada periode ini" icon="trophy" />
        <div class="overflow-x-auto">
            <table class="tbl min-w-[560px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th w-20">Rank</th>
                        <th class="tbl-th">Karyawan</th>
                        <th class="tbl-th">Nilai Akhir (V)</th>
                        <th class="tbl-th text-right">Status Bonus</th>
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @forelse($penilaian->hasilSaws->sortBy('ranking') as $hasil)
                        @php
                            $isDiterima = strtolower($hasil->status_bonus) === 'diterima';
                            $nilai = (float) $hasil->nilai_akhir;
                        @endphp
                        <tr class="tbl-row {{ $isDiterima ? 'bg-emerald-50/40 hover:bg-emerald-50/70' : '' }}">
                            <td class="tbl-td"><x-rank :rank="$hasil->ranking" /></td>
                            <td class="tbl-td">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$hasil->karyawan->nama_karyawan" :seed="$hasil->karyawan->id" size="sm" />
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $hasil->karyawan->nama_karyawan }}</p>
                                        <p class="text-xs text-slate-500">{{ $hasil->karyawan->jabatan ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="tbl-td font-semibold tabular-nums text-indigo-600">
                                {{ number_format($nilai, 4) }}
                            </td>
                            <td class="tbl-td text-right">
                                @if($isDiterima)
                                    <x-badge tone="emerald" icon="check-circle">Diterima</x-badge>
                                @else
                                    <x-badge tone="slate" icon="x-circle">Tidak</x-badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada hasil ranking pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection