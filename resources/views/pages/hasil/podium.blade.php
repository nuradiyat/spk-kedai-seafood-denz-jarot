{{--
================================================================
pages/hasil/podium.blade.php
Partial podium 3 besar + tabel ranking lengkap.
Dipakai oleh: hasil/detail.blade.php
$hasilSaws : Collection HasilSaw (sudah di-sortBy ranking)
================================================================
--}}

{{-- ===== PODIUM TOP 3 ===== --}}
<div class="bg-white rounded-2xl border border-slate-200 p-6 mb-5">
    <h3 class="font-heading font-bold text-ocean text-[15px] text-center mb-6">
        🏆 Penerima Bonus — {{ $penilaian->periode_label }}
    </h3>

    {{-- Podium visual --}}
    <div class="flex items-end justify-center gap-4 sm:gap-8 pb-2">

        {{-- RANK 2 --}}
        @php $r2 = $hasilSaws->firstWhere('ranking', 2); @endphp
        @if ($r2)
            <div class="flex flex-col items-center gap-2">
                <div class="text-2xl">🥈</div>
                <div class="font-semibold text-slate-700 text-sm text-center max-w-[90px] truncate">
                    {{ $r2->karyawan->nama }}</div>
                <div class="text-xs text-slate-400 font-mono">{{ number_format($r2->nilai_akhir, 4) }}</div>
                @if ($r2->jumlah_bonus)
                    <div class="text-xs font-bold text-teal-600">Rp {{ number_format($r2->jumlah_bonus, 0, ',', '.') }}
                    </div>
                @endif
                <div
                    class="w-20 sm:w-24 h-20 sm:h-24 rounded-t-xl bg-gradient-to-t from-slate-400 to-slate-300
                        flex items-center justify-center font-heading font-black text-white text-2xl">
                    2</div>
            </div>
        @endif

        {{-- RANK 1 --}}
        @php $r1 = $hasilSaws->firstWhere('ranking', 1); @endphp
        @if ($r1)
            <div class="flex flex-col items-center gap-2 -mb-2">
                <div class="text-3xl">👑</div>
                <div class="font-heading font-bold text-ocean text-sm text-center max-w-[100px] truncate">
                    {{ $r1->karyawan->nama }}</div>
                <div class="text-xs text-yellow-600 font-mono font-bold">{{ number_format($r1->nilai_akhir, 4) }}</div>
                @if ($r1->jumlah_bonus)
                    <div class="text-xs font-bold text-teal-600">Rp {{ number_format($r1->jumlah_bonus, 0, ',', '.') }}
                    </div>
                @endif
                <div
                    class="w-20 sm:w-28 h-28 sm:h-36 rounded-t-xl bg-gradient-to-t from-yellow-500 to-yellow-300
                        flex items-center justify-center font-heading font-black text-white text-3xl">
                    1</div>
            </div>
        @endif

        {{-- RANK 3 --}}
        @php $r3 = $hasilSaws->firstWhere('ranking', 3); @endphp
        @if ($r3)
            <div class="flex flex-col items-center gap-2">
                <div class="text-2xl">🥉</div>
                <div class="font-semibold text-slate-700 text-sm text-center max-w-[90px] truncate">
                    {{ $r3->karyawan->nama }}</div>
                <div class="text-xs text-slate-400 font-mono">{{ number_format($r3->nilai_akhir, 4) }}</div>
                @if ($r3->jumlah_bonus)
                    <div class="text-xs font-bold text-teal-600">Rp {{ number_format($r3->jumlah_bonus, 0, ',', '.') }}
                    </div>
                @endif
                <div
                    class="w-20 sm:w-24 h-16 sm:h-20 rounded-t-xl bg-gradient-to-t from-orange-400 to-orange-300
                        flex items-center justify-center font-heading font-black text-white text-2xl">
                    3</div>
            </div>
        @endif

    </div>
</div>

{{-- ===== TABEL RANKING LENGKAP ===== --}}
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-5">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <h3 class="font-heading font-bold text-ocean text-[15px]">Ranking Lengkap</h3>
        <button onclick="window.print()"
            class="no-print inline-flex items-center gap-2 text-xs text-slate-500 border border-slate-200
                       rounded-lg px-3 py-1.5 hover:bg-slate-50 transition-colors">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th
                        class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3.5">
                        Rank</th>
                    <th
                        class="text-left   text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                        Karyawan</th>
                    <th class="text-center text-[11px] font-bold text-teal-700 uppercase tracking-wide px-3 py-3.5">Skor
                        V<sub>i</sub></th>
                    <th
                        class="text-left   text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                        Progress</th>
                    <th
                        class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                        Bonus</th>
                    <th
                        class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                        Keputusan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rankBg = [1 => 'bg-yellow-50/50', 2 => 'bg-slate-50/30', 3 => 'bg-orange-50/30'];
                    $rankBadge = [
                        1 => 'bg-yellow-100 text-yellow-700',
                        2 => 'bg-slate-200 text-slate-600',
                        3 => 'bg-orange-100 text-orange-600',
                    ];
                    $barColor = [1 => 'bg-teal', 2 => 'bg-blue-400', 3 => 'bg-coral', 4 => 'bg-blue-300'];
                @endphp
                @foreach ($hasilSaws as $h)
                    <tr class="border-b border-slate-50 last:border-0 tbl-row {{ $rankBg[$h->ranking] ?? '' }}">
                        <td class="px-4 py-3.5 text-center">
                            <span
                                class="{{ $rankBadge[$h->ranking] ?? 'bg-slate-100 text-slate-400' }}
                                     inline-flex items-center justify-center w-7 h-7 rounded-lg font-heading font-bold text-sm">
                                {{ $h->ranking }}
                            </span>
                        </td>
                        <td class="px-3 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <span
                                    class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                                         text-white text-xs font-bold font-heading
                                         bg-gradient-to-br {{ $h->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                                    {{ strtoupper(substr($h->karyawan->nama, 0, 2)) }}
                                </span>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $h->karyawan->nama }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $h->karyawan->posisi }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-3.5 text-center">
                            <span
                                class="font-heading font-bold text-base
                                     {{ $h->ranking <= 2 ? 'text-teal-700' : ($h->ranking <= 4 ? 'text-teal-600' : 'text-slate-500') }}">
                                {{ number_format($h->nilai_akhir, 4) }}
                            </span>
                        </td>
                        <td class="px-3 py-3.5 hidden sm:table-cell">
                            <div class="flex items-center gap-2.5">
                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden min-w-[100px]">
                                    <div class="h-full rounded-full bar {{ $barColor[$h->ranking] ?? 'bg-slate-300' }}"
                                        style="width:{{ $h->nilai_akhir * 100 }}%"></div>
                                </div>
                                <span class="text-xs text-slate-400">{{ round($h->nilai_akhir * 100, 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-3 py-3.5 text-center hidden md:table-cell">
                            @if ($h->jumlah_bonus > 0)
                                <span class="font-semibold text-teal-600 text-sm">
                                    Rp {{ number_format($h->jumlah_bonus, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-slate-300 text-lg">—</span>
                            @endif
                        </td>
                        <td class="px-3 py-3.5 text-center">
                            @if ($h->penerima_bonus)
                                @include('components.badges.status', ['status' => 'bonus'])
                            @elseif($h->ranking == 5)
                                @include('components.badges.status', ['status' => 'pertimbangan'])
                            @else
                                @include('components.badges.status', ['status' => 'tidak'])
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
