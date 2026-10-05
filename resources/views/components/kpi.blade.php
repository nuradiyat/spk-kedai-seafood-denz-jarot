@props(['label', 'value', 'unit' => null, 'icon'])
{{--
    Satu sel KPI untuk strip statistik di Dashboard.
    Letakkan di dalam wrapper grid "gap-px bg-slate-200/70" agar muncul garis sekat tipis.

    <x-kpi label="Total Karyawan" :value="5" unit="orang" icon="users">
        5 karyawan aktif      ← isi slot = keterangan kecil di bawah angka
    </x-kpi>
--}}
<div {{ $attributes->merge(['class' => 'bg-white p-5 sm:p-6']) }}>
    <div class="flex items-center justify-between gap-3">
        <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
        <x-icon :name="$icon" class="h-[18px] w-[18px] text-slate-400" />
    </div>
    <p class="mt-3 flex items-baseline gap-1.5">
        <span class="text-3xl font-semibold tracking-tight tabular-nums text-slate-900">{{ $value }}</span>
        @if ($unit)
            <span class="text-sm text-slate-400">{{ $unit }}</span>
        @endif
    </p>
    <div class="mt-1.5 flex items-center gap-1.5 text-xs text-slate-500">{{ $slot }}</div>
</div>
