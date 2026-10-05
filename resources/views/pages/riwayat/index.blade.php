@extends('layouts.app')

@section('title', 'Riwayat Penilaian')

@section('content')
@php
    $riwayat = collect($penilaians ?? $riwayat ?? []);
    $rows = $riwayat instanceof \Illuminate\Contracts\Pagination\Paginator ? collect($riwayat->items()) : collect($riwayat);
    $totalHasil = $rows->sum(fn ($r) => (int) ($r->hasilSaws ? $r->hasilSaws->count() : 0));
    $selesai = $rows->filter(fn ($r) => $r->hasilSaws && $r->hasilSaws->count() > 0)->count();
    $terakhir = $rows->first();
    $offset = $riwayat instanceof \Illuminate\Contracts\Pagination\Paginator ? ($riwayat->firstItem() ?? 1) - 1 : 0;
@endphp

<x-page-header title="Riwayat Penilaian" subtitle="Daftar histori hasil penilaian dan perhitungan metode SAW" :crumbs="['Metode SAW', 'Riwayat']" />

<div class="mb-5 grid gap-4 sm:grid-cols-3">
    <x-mini-stat icon="history" tone="indigo" label="Total Riwayat" :value="$rows->count().' Periode'" :hint="$selesai.' periode selesai diproses'" />
    <x-mini-stat icon="database" tone="sky" label="Total Data Hasil" :value="$totalHasil.' Data'" hint="Dari seluruh periode" />
    <x-mini-stat icon="calendar-check" tone="emerald" label="Periode Terakhir" :value="$terakhir->periode ?? '-'"
                 :hint="isset($terakhir->tanggal_penilaian) ? \Carbon\Carbon::parse($terakhir->tanggal_penilaian)->translatedFormat('d F Y') : null" />
</div>

<x-card class="overflow-hidden">
    <x-card-header title="Histori Perhitungan" subtitle="Hasil perhitungan tersimpan otomatis setiap kali Proses SAW dijalankan" />
    <div class="overflow-x-auto">
        <table class="tbl min-w-[840px]">
            <thead class="tbl-head">
                <tr>
                    <th class="tbl-th w-16">No</th>
                    <th class="tbl-th">Periode</th>
                    <th class="tbl-th">Tanggal</th>
                    <th class="tbl-th">Admin</th>
                    <th class="tbl-th">Jumlah Hasil</th>
                    <th class="tbl-th text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="tbl-body">
                @forelse ($rows as $r)
                    @php
                        $jumlah = (int) ($r->hasilSaws ? $r->hasilSaws->count() : 0);
                        $admin = $r->user->name ?? 'Admin';
                    @endphp
                    <tr class="tbl-row">
                        <td class="tbl-td tabular-nums text-slate-400">{{ str_pad($offset + $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="tbl-td">
                            <div class="flex items-center gap-3">
                                <x-date-block :date="$r->tanggal_penilaian" />
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $r->periode }}</p>
                                    <p class="text-xs text-slate-500">{{ $jumlah > 0 ? 'Perhitungan selesai' : 'Belum ada hasil perhitungan' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="tbl-td text-slate-600">{{ \Carbon\Carbon::parse($r->tanggal_penilaian)->translatedFormat('d F Y') }}</td>
                        <td class="tbl-td">
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-50 py-1 pl-1 pr-3 ring-1 ring-inset ring-slate-200/70">
                                <span class="grid h-6 w-6 place-items-center rounded-full bg-slate-800 text-[10px] font-bold text-white">{{ mb_strtoupper(mb_substr($admin, 0, 1)) }}</span>
                                <span class="text-xs font-semibold text-slate-700">{{ $admin }}</span>
                            </span>
                        </td>
                        <td class="tbl-td">
                            <x-badge :tone="$jumlah > 0 ? 'indigo' : 'slate'" icon="layers">{{ $jumlah }} Data</x-badge>
                        </td>
                        <td class="tbl-td">
                            <div class="flex items-center justify-end gap-2">
                                <x-icon-button icon="eye" label="Detail" :href="route('riwayat.detail', $r->id)" />
                                <a href="{{ route('riwayat.export', $r->id) }}" class="btn-sm btn-sm-pdf {{ $jumlah > 0 ? '' : 'btn-disabled' }}" @if ($jumlah === 0) aria-disabled="true" tabindex="-1" @endif>
                                    <x-icon name="file-down" class="h-4 w-4 text-rose-500" /> Export PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada riwayat penilaian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection