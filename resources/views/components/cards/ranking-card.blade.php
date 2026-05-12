{{--
================================================================
FILE    : components/cards/ranking-card.blade.php
FUNGSI  : Kartu baris ranking karyawan di dashboard/hasil.
PAKAI   : @include('components.cards.ranking-card', [...])
PARAMS  : $rank, $nama, $inisial, $warna, $vi, $status
================================================================
--}}
<div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">

    {{-- Badge rank --}}
    <span
        class="inline-flex items-center justify-center w-7 h-7 rounded-lg font-heading font-bold text-[13px] shrink-0
                 {{ $rank == 1
                     ? 'bg-yellow-100 text-yellow-700'
                     : ($rank == 2
                         ? 'bg-slate-200 text-slate-600'
                         : ($rank == 3
                             ? 'bg-orange-100 text-orange-600'
                             : 'bg-slate-100 text-slate-400')) }}">
        {{ $rank }}
    </span>

    {{-- Avatar inisial --}}
    <span
        class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-[11px] font-bold font-heading shrink-0
                 bg-gradient-to-br {{ $warna ?? 'from-slate-400 to-slate-600' }}">
        {{ $inisial ?? 'KR' }}
    </span>

    {{-- Nama --}}
    <span class="flex-1 font-semibold text-slate-800 text-sm truncate">{{ $nama ?? 'Karyawan' }}</span>

    {{-- Score bar --}}
    <div class="flex items-center gap-2 min-w-[110px]">
        <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-full rounded-full bar {{ $rank <= 4 ? 'bg-teal' : 'bg-purple-300' }}"
                style="width:{{ ($vi ?? 0) * 100 }}%"></div>
        </div>
        <span class="text-xs font-bold text-ocean w-12 text-right">
            {{ number_format($vi ?? 0, 4) }}
        </span>
    </div>

    {{-- Status badge --}}
    @include('components.badges.status', ['status' => $status ?? 'pertimbangan'])

</div>