@props(['tone' => 'slate', 'dot' => false, 'icon' => null])
{{-- <x-badge tone="emerald" dot>Aktif</x-badge>  |  <x-badge tone="slate" icon="x-circle">Tidak</x-badge> --}}
@php
    $tones = [
        'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'slate' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
        'indigo' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
        'amber' => 'bg-amber-50 text-amber-700 ring-amber-600/25',
        'rose' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'sky' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'violet' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
    ];
    $dots = [
        'emerald' => 'bg-emerald-500', 'slate' => 'bg-slate-400', 'indigo' => 'bg-indigo-500', 'amber' => 'bg-amber-500',
        'rose' => 'bg-rose-500', 'sky' => 'bg-sky-500', 'violet' => 'bg-violet-500',
    ];
@endphp
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset '.($tones[$tone] ?? $tones['slate'])]) }}>
    @if ($dot)
        <span class="h-1.5 w-1.5 rounded-full {{ $dots[$tone] ?? $dots['slate'] }}"></span>
    @endif
    @if ($icon)
        <x-icon :name="$icon" class="h-3.5 w-3.5" />
    @endif
    {{ $slot }}
</span>
