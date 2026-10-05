@props(['icon', 'label', 'value', 'hint' => null, 'tone' => 'indigo'])
@php
    $tones = [
        'indigo' => 'bg-indigo-50 text-indigo-600 ring-indigo-100',
        'violet' => 'bg-violet-50 text-violet-600 ring-violet-100',
        'amber' => 'bg-amber-50 text-amber-600 ring-amber-100',
        'emerald' => 'bg-emerald-50 text-emerald-600 ring-emerald-100',
        'sky' => 'bg-sky-50 text-sky-600 ring-sky-100',
        'rose' => 'bg-rose-50 text-rose-600 ring-rose-100',
    ];
@endphp
<div {{ $attributes->merge(['class' => 'card flex items-center gap-4 p-4 sm:p-5']) }}>
    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl ring-1 ring-inset {{ $tones[$tone] ?? $tones['indigo'] }}">
        <x-icon :name="$icon" class="h-5 w-5" />
    </span>
    <div class="min-w-0">
        <p class="text-xs font-medium text-slate-500">{{ $label }}</p>
        <p class="mt-0.5 truncate text-lg font-bold text-slate-900 sm:text-xl">{{ $value }}</p>
        @if ($hint)
            <p class="truncate text-[11px] text-slate-400">{{ $hint }}</p>
        @endif
    </div>
</div>
