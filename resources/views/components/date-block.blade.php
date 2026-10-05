@props(['date'])
{{-- Kotak tanggal kecil (JUL / 22). Butuh locale "id" agar nama bulan berbahasa Indonesia. --}}
@php $tgl = \Carbon\Carbon::parse($date); @endphp
<span {{ $attributes->merge(['class' => 'flex h-11 w-11 shrink-0 flex-col items-center justify-center rounded-xl bg-white ring-1 ring-inset ring-slate-200']) }}>
    <span class="text-[10px] font-bold uppercase leading-none text-indigo-600">{{ $tgl->translatedFormat('M') }}</span>
    <span class="mt-1 text-sm font-bold leading-none text-slate-900">{{ $tgl->format('j') }}</span>
</span>
