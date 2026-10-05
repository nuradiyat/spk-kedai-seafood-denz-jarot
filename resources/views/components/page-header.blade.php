@props(['title', 'subtitle' => null, 'crumbs' => []])
{{--
    Judul halaman + breadcrumb + tombol aksi.
    <x-page-header title="Data Karyawan" subtitle="..." :crumbs="['Master Data', 'Data Karyawan']">
        <x-slot name="actions"> ...tombol... </x-slot>
    </x-page-header>
--}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="min-w-0">
        @if (count($crumbs))
            <nav aria-label="Breadcrumb" class="mb-2 flex flex-wrap items-center gap-1 text-xs font-medium text-slate-400">
                <a href="{{ url('dashboard') }}" class="transition hover:text-indigo-600">Beranda</a>
                @foreach ($crumbs as $crumb)
                    <span class="flex items-center gap-1">
                        <x-icon name="chevron-right" class="h-3.5 w-3.5 text-slate-300" />
                        <span class="{{ $loop->last ? 'text-slate-600' : '' }}">{{ $crumb }}</span>
                    </span>
                @endforeach
            </nav>
        @endif
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-[28px]">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex flex-wrap items-center gap-2.5">{{ $actions }}</div>
    @endisset
</div>
