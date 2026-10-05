{{-- Kartu putih dasar. Pemakaian: <x-card class="p-6">...</x-card> --}}
<div {{ $attributes->merge(['class' => 'card']) }}>
    {{ $slot }}
</div>
