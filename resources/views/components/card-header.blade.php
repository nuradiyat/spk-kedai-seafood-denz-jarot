@props(['title', 'subtitle' => null, 'icon' => null])
{{-- Header kartu. Isi slot (opsional) tampil di sisi kanan, mis. link "Lihat semua". --}}
<div {{ $attributes->merge(['class' => 'flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6']) }}>
    <div class="flex min-w-0 items-center gap-3">
        @if ($icon)
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                <x-icon :name="$icon" class="h-5 w-5" />
            </span>
        @endif
        <div class="min-w-0">
            <h2 class="text-[15px] font-semibold text-slate-900">{{ $title }}</h2>
            @if ($subtitle)
                <p class="mt-0.5 text-xs text-slate-500">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
    @if (trim((string) $slot) !== '')
        <div class="shrink-0">{{ $slot }}</div>
    @endif
</div>
