@props(['icon', 'label', 'href' => null, 'tone' => 'indigo'])
{{-- Tombol ikon kecil + tooltip CSS (tanpa JS). <x-icon-button icon="eye" label="Detail" :href="url('...')" /> --}}
@php
    $tones = [
        'indigo' => 'hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600',
        'amber' => 'hover:border-amber-200 hover:bg-amber-50 hover:text-amber-600',
        'rose' => 'hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600',
    ];
    $classes = 'group/btn relative inline-grid h-9 w-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-500 transition '.($tones[$tone] ?? $tones['indigo']);
@endphp
@if ($href)
    <a href="{{ $href }}" aria-label="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}>
@else
    <button type="button" aria-label="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}>
@endif
        <x-icon :name="$icon" class="h-4 w-4" />
        <span class="tooltip group-hover/btn:translate-y-0 group-hover/btn:opacity-100">{{ $label }}</span>
@if ($href)
    </a>
@else
    </button>
@endif
