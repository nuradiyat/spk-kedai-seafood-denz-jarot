{{--
================================================================
FILE    : components/forms/input.blade.php
FUNGSI  : Komponen input teks reusable.
PAKAI   : @include('components.forms.input', [...])
PARAMS  : $name, $label, $type, $placeholder, $value, $required, $hint
================================================================
--}}
<div>
    @if (!empty($label))
        <label for="{{ $name ?? '' }}" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
            {{ $label }}
            @if (!empty($required))
                <span class="text-red-400 normal-case font-normal">*</span>
            @endif
        </label>
    @endif

    <input type="{{ $type ?? 'text' }}" id="{{ $name ?? '' }}" name="{{ $name ?? '' }}" value="{{ $value ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}" {{ !empty($required) ? 'required' : '' }}
        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                  text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                  transition-all duration-200 {{ $class ?? '' }}">

    @if (!empty($hint))
        <p class="text-xs text-slate-400 mt-1">{{ $hint }}</p>
    @endif
</div>
