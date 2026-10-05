@props(['items' => [], 'label' => 'data'])
{{-- Footer tabel. Mendukung Collection biasa maupun ->paginate() / ->simplePaginate(). --}}
@php
    $isPaginator = $items instanceof \Illuminate\Contracts\Pagination\Paginator;
    $count = $isPaginator ? $items->count() : count($items);
    $total = $items instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $items->total() : $count;
    $from = $isPaginator ? ($items->firstItem() ?? 0) : ($count ? 1 : 0);
    $to = $isPaginator ? ($items->lastItem() ?? 0) : $count;
    $current = $isPaginator ? $items->currentPage() : 1;
    $prev = $isPaginator ? $items->previousPageUrl() : null;
    $next = $isPaginator ? $items->nextPageUrl() : null;
    $navOn = 'grid h-8 w-8 place-items-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-800';
    $navOff = 'grid h-8 w-8 place-items-center rounded-lg border border-slate-200 text-slate-300';
@endphp
<div class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 px-6 py-4 text-xs text-slate-500 sm:flex-row">
    <p>
        Menampilkan <span class="font-semibold text-slate-700">{{ $from }}–{{ $to }}</span>
        dari <span class="font-semibold text-slate-700">{{ $total }}</span> {{ $label }}
    </p>
    <div class="flex items-center gap-1">
        @if ($prev)
            <a href="{{ $prev }}" class="{{ $navOn }}" aria-label="Sebelumnya"><x-icon name="chevron-left" class="h-4 w-4" /></a>
        @else
            <span class="{{ $navOff }}"><x-icon name="chevron-left" class="h-4 w-4" /></span>
        @endif
        <span class="grid h-8 min-w-8 place-items-center rounded-lg bg-indigo-600 px-2 text-xs font-semibold text-white shadow-sm shadow-indigo-600/25">{{ $current }}</span>
        @if ($next)
            <a href="{{ $next }}" class="{{ $navOn }}" aria-label="Berikutnya"><x-icon name="chevron-right" class="h-4 w-4" /></a>
        @else
            <span class="{{ $navOff }}"><x-icon name="chevron-right" class="h-4 w-4" /></span>
        @endif
    </div>
</div>
