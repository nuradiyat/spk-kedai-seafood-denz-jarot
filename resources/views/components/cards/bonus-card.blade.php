{{--
================================================================
FILE    : components/cards/bonus-card.blade.php
FUNGSI  : Kartu penerima bonus (podium/highlight).
PAKAI   : @include('components.cards.bonus-card', [...])
PARAMS  : $rank, $nama, $inisial, $warna, $vi, $bonus
================================================================
--}}
<div
    class="bg-white rounded-2xl border p-5 flex items-center gap-4 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200
            {{ $rank == 1
                ? 'border-yellow-200 bg-yellow-50/30'
                : ($rank == 2
                    ? 'border-slate-200'
                    : ($rank == 3
                        ? 'border-orange-200 bg-orange-50/20'
                        : 'border-slate-200')) }}">

    {{-- Medal --}}
    <div class="text-3xl shrink-0">
        @if ($rank == 1)
            🥇
        @elseif($rank == 2)
            🥈
        @elseif($rank == 3)
            🥉
        @else
            <span
                class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-heading font-bold text-slate-500 text-base">{{ $rank }}</span>
        @endif
    </div>

    {{-- Avatar + info --}}
    <div class="flex items-center gap-3 flex-1 min-w-0">
        <span
            class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-bold font-heading shrink-0
                     bg-gradient-to-br {{ $warna ?? 'from-slate-400 to-slate-600' }}">
            {{ $inisial ?? 'KR' }}
        </span>
        <div class="min-w-0">
            <p class="font-heading font-bold text-ocean text-sm truncate">{{ $nama ?? 'Karyawan' }}</p>
            <p class="text-xs text-slate-400">V<sub>i</sub> = {{ number_format($vi ?? 0, 4) }}</p>
        </div>
    </div>

    {{-- Bonus amount --}}
    <div class="text-right shrink-0">
        <p class="font-heading font-bold text-teal-600 text-sm">
            Rp {{ number_format($bonus ?? 0, 0, ',', '.') }}
        </p>
        <p class="text-[11px] text-slate-400">Bonus</p>
    </div>

</div>
