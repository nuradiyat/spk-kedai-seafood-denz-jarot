{{--
================================================================
FILE    : components/badges/ranking.blade.php
FUNGSI  : Badge nomor ranking berwarna (1=gold, 2=silver, 3=bronze).
PAKAI   : @include('components.badges.ranking', ['rank' => 1])
================================================================
--}}
@php
    $cls = match ((int) ($rank ?? 0)) {
        1 => 'bg-yellow-100 text-yellow-700',
        2 => 'bg-slate-200 text-slate-600',
        3 => 'bg-orange-100 text-orange-600',
        default => 'bg-slate-100 text-slate-400',
    };
@endphp
<span
    class="{{ $cls }} inline-flex items-center justify-center w-7 h-7 rounded-lg font-heading font-bold text-sm">
    {{ $rank ?? '—' }}
</span>
