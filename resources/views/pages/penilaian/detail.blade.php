@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')
<x-page-header :title="'Detail Penilaian · '.$penilaian->periode" subtitle="Rincian penilaian karyawan per kriteria" :crumbs="['Metode SAW', 'Penilaian', 'Detail']">
    <x-slot name="actions">
        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali
        </a>
        <form method="POST" action="{{ route('hasil.proses', $penilaian->id) }}" class="inline">
            @csrf
            <button type="submit" class="btn btn-primary">
                <x-icon name="play" class="h-4 w-4" /> Proses SAW
            </button>
        </form>
    </x-slot>
</x-page-header>

<div class="grid gap-5 lg:grid-cols-3">
    <x-card class="p-6">
        <div class="flex items-center gap-3">
            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                <x-icon name="calendar" class="h-6 w-6" />
            </span>
            <div>
                <h2 class="text-base font-bold text-slate-900">{{ $penilaian->periode }}</h2>
                <p class="text-xs text-slate-500">ID Periode #PNL-{{ str_pad($penilaian->id, 3, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <dl class="mt-6 divide-y divide-slate-100 text-sm">
            <div class="flex items-center justify-between py-2.5">
                <dt class="text-slate-500">Tanggal Penilaian</dt>
                <dd class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->translatedFormat('d F Y') }}</dd>
            </div>
            <div class="flex items-center justify-between py-2.5">
                <dt class="text-slate-500">Penilai / Admin</dt>
                <dd class="font-semibold text-slate-900">{{ $penilaian->user->name ?? 'Admin' }}</dd>
            </div>
            <div class="flex items-center justify-between py-2.5">
                <dt class="text-slate-500">Jumlah Input Data</dt>
                <dd class="font-semibold text-slate-900">{{ $penilaian->detailPenilaians->count() }} Data</dd>
            </div>
        </dl>
    </x-card>

    <x-card class="overflow-hidden lg:col-span-2">
        <x-card-header title="Data Nilai Karyawan" subtitle="Nilai mentah setiap karyawan pada setiap kriteria" icon="grid" />
        <div class="overflow-x-auto">
            <table class="tbl min-w-[540px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th">Karyawan</th>
                        <th class="tbl-th">Kriteria</th>
                        <th class="tbl-th text-center">Nilai</th>
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @forelse($penilaian->detailPenilaians as $detail)
                        <tr class="tbl-row">
                            <td class="tbl-td">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$detail->karyawan->nama_karyawan" :seed="$detail->karyawan->id" size="sm" />
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $detail->karyawan->nama_karyawan }}</p>
                                        <p class="text-xs text-slate-500">{{ $detail->karyawan->jabatan ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="tbl-td">
                                <div class="flex items-center gap-2">
                                    <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[11px] font-bold text-slate-600">{{ $detail->kriteria->kode }}</span>
                                    <span class="text-sm font-medium text-slate-800">{{ $detail->kriteria->nama_kriteria }}</span>
                                </div>
                            </td>
                            <td class="tbl-td text-center">
                                <span class="inline-grid h-8 min-w-10 place-items-center rounded-lg bg-indigo-50 px-2 text-sm font-bold text-indigo-700 ring-1 ring-inset ring-indigo-100">
                                    {{ $detail->nilai }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada nilai yang dicatat untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection