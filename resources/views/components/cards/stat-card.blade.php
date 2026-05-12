{{--
================================================================
FILE    : components/cards/stat-card.blade.php
FUNGSI  : Kartu statistik ringkasan dashboard.
PAKAI   : @include('components.cards.stat-card', [...])
PARAMS  : $label, $value, $sub, $icon, $color (ocean|sea|coral|warn)
================================================================
--}}
<div
    class="bg-white rounded-2xl border border-slate-200 p-5 relative overflow-hidden
            hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

    {{-- Accent dekoratif pojok --}}
    <div
        class="absolute top-0 right-0 w-20 h-20 rounded-bl-[80px] rounded-tr-2xl opacity-10 pointer-events-none
                {{ ($color ?? 'ocean') === 'ocean'
                    ? 'bg-ocean'
                    : (($color ?? '') === 'sea'
                        ? 'bg-teal'
                        : (($color ?? '') === 'coral'
                            ? 'bg-coral'
                            : 'bg-amber-400')) }}">
    </div>

    {{-- Icon --}}
    <div
        class="w-10 h-10 rounded-xl flex items-center justify-center text-lg mb-4
                {{ ($color ?? 'ocean') === 'ocean'
                    ? 'bg-ocean/10 text-ocean'
                    : (($color ?? '') === 'sea'
                        ? 'bg-teal/10 text-teal-700'
                        : (($color ?? '') === 'coral'
                            ? 'bg-coral/10 text-coral'
                            : 'bg-amber-100 text-amber-600')) }}">
        <i class="fas {{ $icon ?? 'fa-chart-bar' }}"></i>
    </div>

    {{-- Label --}}
    <p class="text-slate-400 text-xs font-medium uppercase tracking-wide mb-1">{{ $label ?? 'Label' }}</p>

    {{-- Nilai utama --}}
    <div class="font-heading font-bold text-ocean text-3xl leading-tight">{{ $value ?? '0' }}</div>

    {{-- Sub keterangan --}}
    @if (!empty($sub))
        <p class="text-slate-400 text-xs mt-1.5">{!! $sub !!}</p>
    @endif
</div>
