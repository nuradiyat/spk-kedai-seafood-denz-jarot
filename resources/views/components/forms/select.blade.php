{{--
================================================================
FILE    : components/forms/select.blade.php
FUNGSI  : Komponen dropdown select reusable.
PAKAI   : @include('components.forms.select', [...])
PARAMS  : $name, $label, $options (array key=>val), $selected, $required
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

    <select id="{{ $name ?? '' }}" name="{{ $name ?? '' }}" {{ !empty($required) ? 'required' : '' }}
        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                   text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                   transition-all duration-200 cursor-pointer {{ $class ?? '' }}">
        @foreach ($options ?? [] as $val => $lbl)
            <option value="{{ $val }}" {{ ($selected ?? '') == $val ? 'selected' : '' }}>
                {{ $lbl }}
            </option>
        @endforeach
    </select>
</div>
