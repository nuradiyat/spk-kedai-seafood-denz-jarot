@props(['name' => '?', 'seed' => 1, 'size' => 'md'])
{{-- Avatar inisial. Warna konsisten berdasarkan "seed" (mis. id karyawan). size: sm | md | lg | xl | none --}}
@php
    $tones = [
        'bg-indigo-100 text-indigo-700',
        'bg-sky-100 text-sky-700',
        'bg-emerald-100 text-emerald-700',
        'bg-amber-100 text-amber-700',
        'bg-rose-100 text-rose-700',
        'bg-violet-100 text-violet-700',
    ];
    $sizes = ['sm' => 'h-8 w-8 text-xs', 'md' => 'h-10 w-10 text-sm', 'lg' => 'h-14 w-14 text-lg', 'xl' => 'h-20 w-20 text-2xl'];
    $initials = collect(preg_split('/\s+/', trim((string) $name)) ?: [])
        ->filter()
        ->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
        ->implode('');
    $tone = $tones[abs(((int) $seed) - 1) % count($tones)];
@endphp
<span {{ $attributes->merge(['class' => 'inline-grid shrink-0 place-items-center rounded-full font-bold '.$tone.' '.($sizes[$size] ?? '')]) }}>{{ $initials !== '' ? $initials : '?' }}</span>
