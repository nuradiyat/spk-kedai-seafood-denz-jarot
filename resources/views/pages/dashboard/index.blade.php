@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $topRanking = collect($topRanking ?? [])->values();
    $kriteria = collect($kriteria ?? []);
    $penilaianTerbaru = collect($penilaianTerbaru ?? []);

    $isDiterima = fn ($h) => strtolower($h->status_bonus ?? '') === 'diterima';
    $penerima = $topRanking->filter($isDiterima);

    $totalKaryawan = $totalKaryawan ?? 0;
    $karyawanAktif = $karyawanAktif ?? $totalKaryawan;
    $totalKriteria = $totalKriteria ?? $kriteria->count();
    $totalPenilaian = $totalPenilaian ?? $penilaianTerbaru->count();
    $penerimaBonus = $penerimaBonus ?? $penerima->count();

    $totalBobot = (float) $kriteria->sum('bobot');
    $bobotValid = $kriteria->isNotEmpty() && abs($totalBobot - 1) < 0.0001;

    $periodeAktif = $penilaianTerbaru->first();
    $namaPeriode = $periodeAktif->periode ?? 'Belum ada periode';
    $tanggalAktif = $periodeAktif && !empty($periodeAktif->tanggal_penilaian) ? \Carbon\Carbon::parse($periodeAktif->tanggal_penilaian)->translatedFormat('d F Y') : '-';
    $jumlahDinilai = (int) ($periodeAktif ? $periodeAktif->hasilSaws->count() : $topRanking->count());

    $juara = $penerima->first() ?? $topRanking->first();
    $runnerUp = $topRanking->get(1);
    $selisih = ($juara && $runnerUp) ? (float) $juara->nilai_akhir - (float) $runnerUp->nilai_akhir : null;

    $diproses = $penilaianTerbaru->filter(fn ($p) => $p->hasilSaws->count() > 0)->count();
    $persenDiproses = $penilaianTerbaru->count() ? ($diproses / $penilaianTerbaru->count()) * 100 : 0;

    $bobotShades = ['bg-indigo-600', 'bg-indigo-500', 'bg-indigo-400', 'bg-indigo-300', 'bg-indigo-200'];

    $tahapan = [
        ['title' => 'Kriteria & bobot', 'desc' => $totalKriteria.' kriteria · total bobot '.number_format($totalBobot, 2), 'done' => $bobotValid],
        ['title' => 'Input penilaian', 'desc' => $periodeAktif ? $jumlahDinilai.' karyawan telah dinilai' : 'Belum ada periode penilaian', 'done' => (bool) $periodeAktif],
        ['title' => 'Normalisasi matriks', 'desc' => 'r = x / max(x) untuk kriteria benefit', 'done' => $topRanking->isNotEmpty()],
        ['title' => 'Perankingan', 'desc' => 'V = Σ w·r · '.$penerima->count().' penerima bonus', 'done' => $topRanking->isNotEmpty()],
    ];
    $semuaSelesai = collect($tahapan)->every(fn ($t) => $t['done']);

    $linkCls = 'inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-50';
@endphp

<x-page-header title="Dashboard" :subtitle="'Selamat datang kembali, '.(auth()->user()->name ?? 'Admin').'. Berikut ringkasan penilaian periode '.$namaPeriode.'.'">
    <x-slot name="actions">
        <a href="{{ route('hasil.index') }}" class="btn btn-secondary">
            <x-icon name="chart" class="h-4 w-4 text-slate-500" /> Hasil SAW
        </a>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('penilaian.create') }}" class="btn btn-primary">
            <x-icon name="plus" class="h-4 w-4" /> Input Penilaian
        </a>
        @endif
    </x-slot>
</x-page-header>

{{-- ================= KPI: satu kartu, 4 kolom bersekat ================= --}}
<div class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-slate-200/70 bg-slate-200/70 shadow-[0_1px_3px_rgba(15,23,42,0.04)] xl:grid-cols-4">
    <x-kpi label="Total Karyawan" :value="$totalKaryawan" unit="orang" icon="users">
        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
        {{ $karyawanAktif }} karyawan aktif
    </x-kpi>
    <x-kpi label="Total Kriteria" :value="$totalKriteria" unit="kriteria" icon="sliders">
        @if ($bobotValid)
            <x-icon name="check-circle" class="h-3.5 w-3.5 text-emerald-500" />
        @else
            <x-icon name="x-circle" class="h-3.5 w-3.5 text-rose-500" />
        @endif
        Total bobot {{ number_format($totalBobot, 2) }}
    </x-kpi>
    <x-kpi label="Total Penilaian" :value="$totalPenilaian" unit="periode" icon="clipboard">
        {{ $periodeAktif ? 'Terakhir '.$tanggalAktif : 'Belum ada penilaian' }}
    </x-kpi>
    <x-kpi label="Penerima Bonus" :value="$penerimaBonus" unit="orang" icon="trophy">
        {{ $penerima->isNotEmpty() ? $penerima->map(fn ($h) => $h->karyawan->nama_karyawan ?? '-')->implode(', ').' · '.$namaPeriode : 'Belum ada penerima' }}
    </x-kpi>
</div>

{{-- ================= Ranking + penerima bonus ================= --}}
<div class="mt-5 grid gap-5 xl:grid-cols-3">
    <x-card class="overflow-hidden xl:col-span-2">
        <x-card-header title="Ranking Karyawan" :subtitle="'Hasil perhitungan SAW · '.$namaPeriode">
            <a href="{{ route('hasil.index') }}" class="{{ $linkCls }}">Lihat semua <x-icon name="chevron-right" class="h-3.5 w-3.5" /></a>
        </x-card-header>
        <div class="overflow-x-auto">
            <table class="tbl min-w-[560px]">
                <thead class="tbl-head">
                    <tr>
                        <th class="tbl-th w-20">Rank</th>
                        <th class="tbl-th">Karyawan</th>
                        <th class="tbl-th">Nilai Akhir (V)</th>
                        <th class="tbl-th text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="tbl-body">
                    @forelse ($topRanking as $h)
                        @php
                            $rank = (int) ($h->ranking ?? $loop->iteration);
                            $nilai = (float) ($h->nilai_akhir ?? 0);
                        @endphp
                        <tr class="tbl-row">
                            <td class="tbl-td py-4">
                                <span class="inline-grid h-7 w-7 place-items-center rounded-lg text-xs font-semibold tabular-nums {{ $rank === 1 ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500' }}">{{ $rank }}</span>
                            </td>
                            <td class="tbl-td py-4">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$h->karyawan->nama_karyawan ?? '-'" :seed="$h->karyawan->id ?? $loop->iteration" size="sm" />
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $h->karyawan->nama_karyawan ?? '-' }}</p>
                                        <p class="text-xs text-slate-500">{{ $h->karyawan->jabatan ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="tbl-td w-64 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-11 font-semibold tabular-nums text-slate-900">{{ number_format($nilai, 3) }}</span>
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full {{ $rank === 1 ? 'bg-indigo-600' : 'bg-indigo-200' }}" style="width: {{ min(100, max(0, $nilai * 100)) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="tbl-td py-4 text-right">
                                @if ($isDiterima($h))
                                    <x-badge tone="emerald" icon="check-circle">Diterima</x-badge>
                                @else
                                    <x-badge tone="slate" icon="x-circle">Tidak</x-badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada hasil perhitungan SAW.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <x-card class="p-5 sm:p-6">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-[15px] font-semibold text-slate-900">Penerima Bonus</h2>
            <span class="text-xs font-medium text-slate-400">{{ $namaPeriode }}</span>
        </div>

        @if ($juara)
            <div class="mt-5 grid gap-5 md:grid-cols-3 md:items-center xl:grid-cols-1">
                <div class="flex items-center gap-3.5">
                    <x-avatar :name="$juara->karyawan->nama_karyawan ?? '-'" :seed="$juara->karyawan->id ?? 1" size="lg" />
                    <div class="min-w-0">
                        <p class="truncate text-base font-semibold text-slate-900">{{ $juara->karyawan->nama_karyawan ?? '-' }}</p>
                        <p class="truncate text-sm text-slate-500">{{ $juara->karyawan->jabatan ?? 'Karyawan' }}</p>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                    <p class="text-xs font-medium text-slate-500">Nilai akhir (V)</p>
                    <p class="mt-1 text-3xl font-semibold tracking-tight tabular-nums text-slate-900">{{ number_format((float) $juara->nilai_akhir, 3) }}</p>
                    @if (! is_null($selisih))
                        <p class="mt-1 flex items-center gap-1 text-xs font-medium text-emerald-600">
                            <x-icon name="trending-up" class="h-3.5 w-3.5" /> +{{ number_format($selisih, 3) }} dari peringkat 2
                        </p>
                    @endif
                </div>

                <div>
                    <dl class="divide-y divide-slate-100 text-sm">
                        <div class="flex items-center justify-between gap-3 pb-2.5">
                            <dt class="text-slate-500">Peringkat</dt>
                            <dd class="font-medium text-slate-900">#{{ $juara->ranking ?? 1 }} dari {{ $jumlahDinilai }} karyawan</dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 py-2.5">
                            <dt class="text-slate-500">Tanggal</dt>
                            <dd class="font-medium text-slate-900">{{ $tanggalAktif }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 pt-2.5">
                            <dt class="text-slate-500">Status</dt>
                            <dd>
                                @if ($isDiterima($juara))
                                    <x-badge tone="emerald" icon="check-circle">Diterima</x-badge>
                                @else
                                    <x-badge tone="slate" icon="x-circle">Tidak</x-badge>
                                @endif
                            </dd>
                        </div>
                    </dl>
                    <a href="{{ route('hasil.podium') }}" class="btn btn-secondary mt-5 h-10 w-full">
                        <x-icon name="trophy" class="h-4 w-4 text-slate-500" /> Lihat Podium
                    </a>
                </div>
            </div>
        @else
            <div class="mt-5 rounded-xl border border-dashed border-slate-200 px-4 py-10 text-center text-sm text-slate-500">
                Belum ada hasil perhitungan SAW.
            </div>
        @endif
    </x-card>
</div>

{{-- ================= Bobot + penilaian terbaru + tahapan ================= --}}
<div class="mt-5 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
    <x-card class="flex flex-col">
        <x-card-header title="Bobot Kriteria" :subtitle="$totalKriteria.' kriteria · total bobot '.number_format($totalBobot, 2)">
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('kriteria.index') }}" class="{{ $linkCls }}">Kelola <x-icon name="chevron-right" class="h-3.5 w-3.5" /></a>
            @endif
        </x-card-header>
        <div class="p-5 sm:p-6">
            <div class="flex h-2 gap-0.5 overflow-hidden rounded-full bg-slate-100">
                @foreach ($kriteria as $k)
                    <div class="{{ $bobotShades[$loop->index % count($bobotShades)] }}" style="width: {{ (float) $k->bobot * 100 }}%"></div>
                @endforeach
            </div>
            <ul class="mt-5 space-y-3.5">
                @forelse ($kriteria as $k)
                    <li class="flex items-center gap-3 text-sm">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-[3px] {{ $bobotShades[$loop->index % count($bobotShades)] }}"></span>
                        <span class="w-7 shrink-0 text-xs font-semibold text-slate-400">{{ $k->kode ?? 'C'.$loop->iteration }}</span>
                        <span class="min-w-0 flex-1 truncate text-slate-700">{{ $k->nama_kriteria ?? '-' }}</span>
                        <span class="font-semibold tabular-nums text-slate-900">{{ round((float) $k->bobot * 100) }}%</span>
                    </li>
                @empty
                    <li class="text-sm text-slate-500">Belum ada data kriteria.</li>
                @endforelse
            </ul>
        </div>
    </x-card>

    <x-card class="flex flex-col">
        <x-card-header title="Penilaian Terbaru" :subtitle="$penilaianTerbaru->count().' periode terakhir'">
            <a href="{{ route('riwayat.index') }}" class="{{ $linkCls }}">Riwayat <x-icon name="chevron-right" class="h-3.5 w-3.5" /></a>
        </x-card-header>
        <ul class="divide-y divide-slate-100">
            @forelse ($penilaianTerbaru as $p)
                @php $jumlahHasil = (int) $p->hasilSaws->count(); @endphp
                <li class="flex items-center gap-3 px-5 py-3.5 sm:px-6">
                    <x-date-block :date="$p->tanggal_penilaian" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $p->periode }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $jumlahHasil }} hasil · oleh {{ $p->user->name ?? 'Admin' }}</p>
                    </div>
                    @if ($jumlahHasil > 0)
                        <x-badge tone="emerald" dot>Selesai</x-badge>
                    @else
                        <x-badge tone="amber" dot>Menunggu</x-badge>
                    @endif
                </li>
            @empty
                <li class="px-6 py-10 text-center text-sm text-slate-500">Belum ada penilaian.</li>
            @endforelse
        </ul>
        <div class="mt-auto border-t border-slate-100 px-5 py-4 sm:px-6">
            <div class="flex items-center justify-between text-xs">
                <span class="text-slate-500">Periode sudah diproses</span>
                <span class="font-semibold tabular-nums text-slate-900">{{ $diproses }} / {{ $penilaianTerbaru->count() }}</span>
            </div>
            <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-indigo-600" style="width: {{ $persenDiproses }}%"></div>
            </div>
        </div>
    </x-card>

    <x-card class="flex flex-col md:col-span-2 xl:col-span-1">
        <x-card-header title="Tahapan SAW" :subtitle="'Status periode '.$namaPeriode">
            @if ($semuaSelesai)
                <x-badge tone="emerald" dot>Selesai</x-badge>
            @else
                <x-badge tone="amber" dot>Dalam proses</x-badge>
            @endif
        </x-card-header>
        <ol class="grid gap-5 p-5 sm:p-6 md:grid-cols-4 xl:grid-cols-1">
            @foreach ($tahapan as $t)
                <li class="relative flex gap-3">
                    @unless ($loop->last)
                        <span class="absolute -bottom-5 left-[13.5px] top-8 w-px bg-slate-200 md:hidden xl:block"></span>
                    @endunless
                    <span class="relative grid h-7 w-7 shrink-0 place-items-center rounded-full {{ $t['done'] ? 'bg-indigo-600 text-white' : 'border border-slate-300 bg-white text-slate-400' }}">
                        @if ($t['done'])
                            <x-icon name="check" class="h-3.5 w-3.5" stroke-width="3" />
                        @else
                            <span class="text-xs font-semibold">{{ $loop->iteration }}</span>
                        @endif
                    </span>
                    <div class="min-w-0 pt-0.5">
                        <p class="text-sm font-semibold text-slate-900">{{ $t['title'] }}</p>
                        <p class="mt-0.5 text-xs leading-relaxed text-slate-500">{{ $t['desc'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </x-card>
</div>
@endsection