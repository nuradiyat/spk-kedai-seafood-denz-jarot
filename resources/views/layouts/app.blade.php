<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · SPK Bonus Karyawan</title>

    {{-- Font (CSS saja) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- CSS SPK Dashboard --}}
    <link rel="stylesheet" href="{{ asset('css/spk-dashboard.css') }}">
</head>
<body class="bg-[#F5F7FB] font-sans text-slate-800 antialiased">

@php
    $userName = auth()->user()->name ?? 'Pengguna';
    $userRole = auth()->user()->role ?? 'admin';
    $userInitial = mb_strtoupper(mb_substr($userName, 0, 1));

    // Pengaturan menu berdasarkan role
    if ($userRole === 'admin') {
        $menus = [
            'Menu Utama' => [
                ['url' => route('dashboard'), 'label' => 'Dashboard', 'icon' => 'dashboard', 'pattern' => ['dashboard']],
            ],
            'Master Data' => [
                ['url' => route('karyawan.index'), 'label' => 'Data Karyawan', 'icon' => 'users', 'pattern' => ['karyawan*']],
                ['url' => route('kriteria.index'), 'label' => 'Data Kriteria', 'icon' => 'sliders', 'pattern' => ['kriteria*']],
            ],
            'Metode SAW' => [
                ['url' => route('penilaian.index'), 'label' => 'Penilaian', 'icon' => 'clipboard', 'pattern' => ['penilaian*']],
                ['url' => route('hasil.index'), 'label' => 'Hasil SAW', 'icon' => 'chart', 'pattern' => ['hasil*']],
                ['url' => route('riwayat.index'), 'label' => 'Riwayat', 'icon' => 'history', 'pattern' => ['riwayat*']],
            ],
        ];
    } else {
        // Role Owner
        $menus = [
            'Menu Utama' => [
                ['url' => route('dashboard'), 'label' => 'Dashboard', 'icon' => 'dashboard', 'pattern' => ['dashboard']],
            ],
            'Laporan & Hasil' => [
                ['url' => route('hasil.index'), 'label' => 'Hasil SAW', 'icon' => 'chart', 'pattern' => ['hasil*']],
                ['url' => route('riwayat.index'), 'label' => 'Riwayat', 'icon' => 'history', 'pattern' => ['riwayat*']],
            ],
        ];
    }
@endphp

{{-- ================= Toggle sidebar (mobile) — CSS murni ================= --}}
<input type="checkbox" id="sidebar-toggle" class="peer hidden">
<label for="sidebar-toggle" aria-hidden="true"
       class="pointer-events-none fixed inset-0 z-40 bg-slate-900/40 opacity-0 backdrop-blur-[2px] transition-opacity duration-300 peer-checked:pointer-events-auto peer-checked:opacity-100 lg:hidden"></label>

{{-- ================================ SIDEBAR ================================ --}}
<aside class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200/80 bg-white transition-transform duration-300 ease-out peer-checked:translate-x-0 lg:translate-x-0">
    <div class="flex h-[72px] shrink-0 items-center justify-between px-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-sky-400 via-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30">
                <x-icon name="fish" class="h-5 w-5" stroke-width="2.25" />
            </span>
            <span class="leading-tight">
                <span class="block text-base font-extrabold tracking-tight text-slate-900">Denz Jarot</span>
                <span class="block text-[11px] font-medium text-slate-500">Sistem Pendukung Keputusan</span>
            </span>
        </a>
        <label for="sidebar-toggle" aria-label="Tutup menu"
               class="grid h-9 w-9 cursor-pointer place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 lg:hidden">
            <x-icon name="x" class="h-5 w-5" />
        </label>
    </div>

    <nav class="scrollbar-thin flex-1 overflow-y-auto px-4 pb-4 pt-2">
        @foreach ($menus as $section => $items)
            <div class="mt-5 first:mt-0">
                <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-400">{{ $section }}</p>
                <ul class="space-y-1">
                    @foreach ($items as $item)
                        @php $active = request()->is(...$item['pattern']); @endphp
                        <li>
                            <a href="{{ $item['url'] }}" @if ($active) aria-current="page" @endif
                               class="group relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ $active ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                @if ($active)
                                    <span class="absolute -left-4 top-1/2 h-6 w-1.5 -translate-y-1/2 rounded-r-full bg-indigo-600"></span>
                                @endif
                                <x-icon :name="$item['icon']" class="h-5 w-5 transition-colors {{ $active ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" />
                                <span class="flex-1 truncate">{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    <div class="shrink-0 border-t border-slate-100 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-2.5 ring-1 ring-inset ring-slate-200/70">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-slate-700 to-slate-900 text-sm font-bold text-white">{{ $userInitial }}</span>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-900">{{ $userName }}</p>
                <p class="truncate text-xs text-slate-500">{{ ucfirst($userRole) }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex h-9 items-center gap-1.5 rounded-lg px-2.5 text-xs font-semibold text-slate-500 transition hover:bg-rose-50 hover:text-rose-600">
                    <x-icon name="logout" class="h-4 w-4" /> Logout
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ============================ KONTEN UTAMA ============================ --}}
<div class="flex min-h-screen flex-col lg:pl-72">
    <header class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl">
        <div class="flex h-[72px] items-center gap-3 px-4 sm:px-6 lg:px-8">
            <label for="sidebar-toggle" aria-label="Buka menu"
                   class="grid h-10 w-10 shrink-0 cursor-pointer place-items-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 lg:hidden">
                <x-icon name="menu" class="h-5 w-5" />
            </label>

            <div class="md:hidden">
                <p class="text-sm font-extrabold tracking-tight text-slate-900">Denz Jarot</p>
                <p class="text-[11px] font-medium text-slate-500">SPK Bonus Karyawan</p>
            </div>

            {{-- Pencarian: GET ke halaman karyawan (?search=...) jika role admin --}}
            @if ($userRole === 'admin')
            <form method="GET" action="{{ route('karyawan.index') }}" role="search" class="relative hidden w-full max-w-md md:block">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari karyawan, kriteria, atau periode..."
                       class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/80 pl-10 pr-4 text-sm text-slate-900 transition placeholder:text-slate-400 hover:border-slate-300 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100">
            </form>
            @endif

            <div class="ml-auto flex items-center gap-2 sm:gap-3">
                <div class="hidden items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-600 xl:flex">
                    <x-icon name="calendar" class="h-4 w-4 text-indigo-500" />
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <span class="hidden h-8 w-px bg-slate-200 xl:block"></span>
                <div class="flex items-center gap-3">
                    <div class="hidden text-right leading-tight sm:block">
                        <p class="text-sm font-semibold text-slate-900">{{ $userName }}</p>
                        <p class="text-[11px] font-medium text-slate-500">Login sebagai {{ ucfirst($userRole) }}</p>
                    </div>
                    <span class="relative grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 text-sm font-bold text-white shadow-md shadow-indigo-500/25">
                        {{ $userInitial }}
                        <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto w-full max-w-7xl animate-page-in">

            {{-- Flash message --}}
            @foreach (['success' => ['emerald', 'check-circle'], 'error' => ['rose', 'x-circle']] as $key => [$tone, $icon])
                @if (session($key))
                    <div>
                        <input type="checkbox" id="flash-{{ $key }}" class="peer hidden">
                        <div class="mb-6 flex items-start gap-3 rounded-2xl border px-4 py-3.5 text-sm peer-checked:hidden {{ $tone === 'emerald' ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-rose-200 bg-rose-50 text-rose-800' }}">
                            <x-icon :name="$icon" class="mt-0.5 h-5 w-5 {{ $tone === 'emerald' ? 'text-emerald-600' : 'text-rose-600' }}" />
                            <p class="flex-1 font-medium">{{ session($key) }}</p>
                            <label for="flash-{{ $key }}" class="cursor-pointer rounded-md p-0.5 opacity-60 transition hover:opacity-100" aria-label="Tutup">
                                <x-icon name="x" class="h-4 w-4" />
                            </label>
                        </div>
                    </div>
                @endif
            @endforeach

            @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-800">
                    <x-icon name="x-circle" class="mt-0.5 h-5 w-5 text-rose-600" />
                    <div>
                        <p class="font-semibold">Periksa kembali isian kamu:</p>
                        <ul class="mt-1 list-inside list-disc space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="px-4 pb-6 sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 border-t border-slate-200/70 pt-5 text-xs text-slate-400 sm:flex-row">
            <p>© {{ date('Y') }} Denz Jarot · Sistem Pendukung Keputusan Bonus Karyawan</p>
            <p>Metode <span class="font-semibold text-slate-500">Simple Additive Weighting (SAW)</span></p>
        </div>
    </footer>
</div>

</body>
</html>