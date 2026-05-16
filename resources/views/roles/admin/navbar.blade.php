<header
    class="bg-white border-b border-slate-200 h-16 flex items-center justify-between
           px-4 lg:px-7 sticky top-0 z-30 shrink-0">

    {{-- KIRI --}}
    <div class="flex items-center gap-3 min-w-0">

        <button onclick="toggleSidebar()"
            class="lg:hidden text-ocean text-xl p-1
                   hover:text-ocean-lt transition-colors shrink-0">

            <i class="fas fa-bars"></i>

        </button>

        <div class="min-w-0">

            <h3 class="font-heading font-bold text-ocean
                       text-[17px] leading-tight truncate">

                @yield('page-title', 'Dashboard')

            </h3>

            <p class="text-slate-400 text-[12px]
                      hidden sm:block truncate">

                @yield('page-subtitle')

            </p>

        </div>

    </div>

    {{-- KANAN --}}
    <div class="flex items-center gap-2.5 shrink-0">

        {{-- Periode --}}
        <div
            class="hidden sm:flex items-center gap-2
                   bg-sand border border-sand-dk
                   rounded-lg px-3 py-1.5
                   text-[12px] font-medium text-slate-600">

            <i class="fas fa-calendar-alt text-slate-400 text-xs"></i>

            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}

        </div>

        {{-- Notifikasi --}}
        <div class="relative">

            <button
                class="w-9 h-9 rounded-lg bg-sand border border-sand-dk
                       flex items-center justify-center
                       text-slate-500 hover:bg-slate-200
                       transition-colors">

                <i class="fas fa-bell text-sm"></i>

            </button>

            <span
                class="absolute top-1.5 right-1.5
                       w-2 h-2 rounded-full
                       bg-coral border-2 border-white">
            </span>

        </div>

        {{-- Avatar --}}
        <div
            class="lg:hidden w-9 h-9 rounded-xl
                   bg-gradient-to-br from-ocean to-ocean-lt
                   flex items-center justify-center
                   font-heading font-bold text-white text-xs">

            {{ strtoupper(substr(auth()->user()->nama ?? 'AD', 0, 2)) }}

        </div>

    </div>

</header>
