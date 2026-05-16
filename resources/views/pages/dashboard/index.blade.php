{{--
================================================================
pages/dashboard/index.blade.php
Halaman dashboard utama SPK.
Menampilkan: statistik, ranking, bobot kriteria, aktivitas terbaru.
Controller: DashboardController@index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Dashboard — SPK Denz Jarot')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'SPK Bonus Karyawan — Denz Jarot Seafood')

@section('content')

    {{-- ================================================================
     BAGIAN 1: KARTU STATISTIK
================================================================ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- Total Karyawan --}}
        <div
            class="bg-white rounded-2xl border border-slate-200 p-5 relative overflow-hidden
                hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[80px] rounded-tr-2xl bg-ocean opacity-10"></div>
            <div class="w-10 h-10 rounded-xl bg-ocean/10 text-ocean flex items-center justify-center text-lg mb-4">
                <i class="fas fa-users"></i>
            </div>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-wide mb-1">Total Karyawan</p>
            <div class="font-heading font-bold text-ocean text-3xl">{{ $totalKaryawan ?? 0 }}</div>
            <p class="text-slate-400 text-xs mt-1.5">
                <span class="text-teal font-semibold">+{{ $karyawanBaru ?? 0 }}</span> bulan ini
            </p>
        </div>

        {{-- Penerima Bonus --}}
        <div
            class="bg-white rounded-2xl border border-slate-200 p-5 relative overflow-hidden
                hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[80px] rounded-tr-2xl bg-teal opacity-10"></div>
            <div class="w-10 h-10 rounded-xl bg-teal/10 text-teal-700 flex items-center justify-center text-lg mb-4">
                <i class="fas fa-trophy"></i>
            </div>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-wide mb-1">Penerima Bonus</p>
            <div class="font-heading font-bold text-ocean text-3xl">{{ $penerimaBonus ?? 0 }}</div>
            <p class="text-slate-400 text-xs mt-1.5">Periode {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        </div>

        {{-- totalPenilaian --}}
        <div
            class="bg-white rounded-2xl border border-slate-200 p-5 relative overflow-hidden
                hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[80px] rounded-tr-2xl bg-coral opacity-10"></div>
            <div class="w-10 h-10 rounded-xl bg-coral/10 text-coral flex items-center justify-center text-lg mb-4">
                <i class="fas fa-chart-bar"></i>
            </div>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-wide mb-1">Total Penilaian</p>
            <div class="font-heading font-bold text-ocean text-3xl">
                {{ $totalPenilaian ?? 0 }}
            </div>
            <p class="text-slate-400 text-xs mt-1.5">dalam periode berjalan</p>
        </div>

        {{-- Penilaian Selesai --}}
        <div
            class="bg-white rounded-2xl border border-slate-200 p-5 relative overflow-hidden
                hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[80px] rounded-tr-2xl bg-amber-400 opacity-10"></div>
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg mb-4">
                <i class="fas fa-chart-line"></i>
            </div>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-wide mb-1">Penilaian Selesai</p>
            <div class="font-heading font-bold text-ocean text-3xl">{{ $persenSelesai ?? 0 }}%</div>
            <p class="text-slate-400 text-xs mt-1.5">
                {{ $dinilai ?? 0 }} dari {{ $totalKaryawan ?? 0 }} karyawan
            </p>
        </div>

    </div>

    {{-- ================================================================
     BAGIAN 2: RANKING + BOBOT KRITERIA
================================================================ --}}
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-5 mb-5">

        {{-- Tabel Ranking (3/5) --}}
        <div class="xl:col-span-3 bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 pt-5 pb-3">
                <h3 class="font-heading font-bold text-ocean text-[15px]">Ranking Karyawan Terbaik</h3>
                <a href="{{ route('hasil.index') }}"
                    class="text-xs text-slate-500 border border-slate-200 rounded-lg px-3 py-1.5 hover:bg-slate-50 transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th
                                class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">
                                #</th>
                            <th
                                class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3">
                                Karyawan</th>
                            <th
                                class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3">
                                Skor Vi</th>
                            <th
                                class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rankBadge = [
                                1 => 'bg-yellow-100 text-yellow-700',
                                2 => 'bg-slate-200 text-slate-600',
                                3 => 'bg-orange-100 text-orange-600',
                            ];
                        @endphp

                        @forelse($topRanking ?? [] as $item)
                            <tr class="border-b border-slate-50 last:border-0 tbl-row">
                                <td class="px-5 py-3">
                                    <span
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg
                                         font-heading font-bold text-[13px]
                                         {{ $rankBadge[$item->ranking] ?? 'bg-slate-50 text-slate-400' }}">
                                        {{ $item->ranking }}
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="w-8 h-8 rounded-lg flex items-center justify-center
                                          text-white text-[11px] font-bold font-heading shrink-0
                                            bg-gradient-to-br from-ocean to-teal">
                                            {{ strtoupper(substr($item->karyawan->nama, 0, 2)) }}
                                        </span>
                                        <span class="font-semibold text-slate-800">{{ $item->karyawan->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-3 min-w-[140px]">
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full bar {{ $item->ranking <= 4 ? 'bg-teal' : 'bg-purple-300' }}"
                                                style="width:{{ $item->nilai_akhir * 100 }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-ocean w-12 text-right">
                                            {{ number_format($item->nilai_akhir, 4) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    @include('components.badges.status', [
                                        'status' => $item->status_bonus == 'Diterima' ? 'bonus' : 'pertimbangan',
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-14 text-center">
                                    <i class="fas fa-calculator text-4xl text-slate-200 block mb-3"></i>
                                    <p class="text-slate-400 text-sm">Belum ada hasil perhitungan SAW</p>
                                    <a href="{{ route('penilaian.create') }}"
                                        class="text-teal text-sm font-medium mt-2 inline-block hover:underline">
                                        Mulai penilaian →
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bobot Kriteria (2/5) --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 p-5">
            <h3 class="font-heading font-bold text-ocean text-[15px] mb-4">Bobot Kriteria</h3>
            @php
                $palette = ['bg-ocean', 'bg-teal', 'bg-coral', 'bg-blue-400', 'bg-amber-400'];
            @endphp
            <div class="space-y-3.5">
                @forelse($kriterias ?? [] as $idx => $k)
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-sm {{ $palette[$idx % 5] }} shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-slate-700 mb-1 truncate">{{ $k->nama }}</p>
                            <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bar {{ $palette[$idx % 5] }}"
                                    style="width:{{ $k->bobot }}%"></div>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-slate-600 min-w-[38px] text-right">
                            {{ $k->bobot * 100 }}%
                        </span>
                    </div>
                @empty
                    <p class="text-slate-400 text-xs text-center py-4">Belum ada kriteria</p>
                @endforelse
            </div>
            <div class="mt-5 p-3.5 bg-teal-bg border border-teal-200 rounded-xl">
                <p class="text-xs font-semibold text-teal-700 mb-1">
                    <i class="fas fa-info-circle mr-1.5"></i>Metode SAW
                </p>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Normalisasi matriks keputusan kemudian dikalikan bobot tiap kriteria untuk mendapat nilai V<sub>i</sub>.
                </p>
            </div>
        </div>

    </div>

    {{-- ================================================================
     BAGIAN 3: AKTIVITAS TERBARU
================================================================ --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5">
        <h3 class="font-heading font-bold text-ocean text-[15px] mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-2.5">
            @forelse($aktivitas ?? [] as $act)
                <div class="flex items-center gap-4 bg-sand rounded-xl px-4 py-3">
                    <div
                        class="w-9 h-9 rounded-xl {{ $act->bg_class ?? 'bg-teal-50 text-teal-600' }}
                        flex items-center justify-center text-sm shrink-0">
                        <i class="fas {{ $act->icon ?? 'fa-check' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-medium text-slate-800 truncate">{{ $act->title }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $act->time }}</p>
                    </div>
                    @include('components.badges.status', ['status' => $act->status ?? 'selesai'])
                </div>
            @empty
                <p class="text-slate-400 text-sm text-center py-8">
                    <i class="fas fa-clock text-3xl text-slate-200 block mb-2"></i>
                    Belum ada aktivitas
                </p>
            @endforelse
        </div>
    </div>

@endsection
