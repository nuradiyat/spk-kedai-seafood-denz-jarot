{{--
================================================================
FILE    : components/forms/button.blade.php
FUNGSI  : Komponen tombol reusable.
PAKAI   : @include('components.forms.button', [...])
PARAMS  : $label, $type, $variant (primary|secondary|danger|success),
          $icon, $href, $size (sm|md|lg)
================================================================
--}}
@php
    $variants = [
        'primary' => 'bg-gradient-to-r from-ocean to-ocean-lt text-white hover:shadow-md hover:shadow-ocean/25',
        'secondary' => 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50',
        'danger' => 'bg-red-500 text-white hover:bg-red-600',
        'success' => 'bg-gradient-to-r from-teal-500 to-teal text-white hover:shadow-md hover:shadow-teal/25',
    ];
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs rounded-lg',
        'md' => 'px-5 py-2.5 text-sm rounded-xl',
        'lg' => 'px-7 py-3 text-base rounded-xl',
    ];
    $cls = ($variants[$variant ?? 'primary'] ?? $variants['primary']) . ' ' . ($sizes[$size ?? 'md'] ?? $sizes['md']);
@endphp

@if (!empty($href))
    <a href="{{ $href }}"
        class="inline-flex items-center gap-2 font-medium transition-all duration-200 hover:-translate-y-0.5 {{ $cls }}">
        @if (!empty($icon))
            <i class="fas {{ $icon }} text-xs"></i>
        @endif
        {{ $label ?? 'Tombol' }}
    </a>
@else
    <button type="{{ $type ?? 'submit' }}"
        class="inline-flex items-center gap-2 font-medium transition-all duration-200 hover:-translate-y-0.5 {{ $cls }}">
        @if (!empty($icon))
            <i class="fas {{ $icon }} text-xs"></i>
        @endif
        {{ $label ?? 'Tombol' }}
    </button>
@endif
