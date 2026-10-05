@props(['rank' => 0])
{{-- Lencana peringkat: 1 emas, 2 perak, 3 perunggu, sisanya abu-abu --}}
@php
    $tone = match ((int) $rank) {
        1 => 'bg-gradient-to-br from-amber-300 to-amber-500 text-white shadow-md shadow-amber-500/30 ring-4 ring-amber-50',
        2 => 'bg-gradient-to-br from-slate-300 to-slate-400 text-white shadow-md shadow-slate-400/30 ring-4 ring-slate-100',
        3 => 'bg-gradient-to-br from-orange-300 to-orange-500 text-white shadow-md shadow-orange-500/30 ring-4 ring-orange-50',
        default => 'bg-slate-100 text-slate-500 ring-1 ring-inset ring-slate-200',
    };
@endphp
<span {{ $attributes->merge(['class' => 'inline-grid h-9 w-9 shrink-0 place-items-center rounded-full text-sm font-bold tabular-nums '.$tone]) }}>{{ $rank }}</span>
