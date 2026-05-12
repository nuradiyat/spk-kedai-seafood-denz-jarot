{{--
================================================================
FILE    : layouts/sidebar.blade.php
FUNGSI  : Sidebar navigasi utama sistem SPK.
          Berisi logo, menu navigasi terstruktur, dan profil user.
          Responsive: hidden di mobile, visible di lg+.
================================================================
--}}
<aside id="sidebar"
    class="sb-scroll fixed top-0 left-0 h-full w-64 bg-ocean flex flex-col z-50
              -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">

    {{-- ===== LOGO BRAND ===== --}}
    <div class="flex items-center gap-3 px-5 py-6 border-b border-white/[.07] shrink-0">
        <div
            class="w-11 h-11 rounded-xl bg-gradient-to-br from-teal to-teal-600
                    flex items-center justify-center text-xl shrink-0">
            🐟</div>
        <div>
            <h2 class="font-heading font-bold text-white text-[15px] leading-snug">Denz Jarot</h2>
            <span class="text-white/40 text-[11px]">SPK Bonus Karyawan</span>
        </div>
    </div>

    {{-- ===== NAVIGASI UTAMA ===== --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5">

        {{-- GRUP: UTAMA --}}
        <p class="text-white/30 text-[10px] font-semibold tracking-widest uppercase px-2 pt-1 pb-1.5">Utama</p>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] nav-active font-medium">
            <i class="fas fa-th-large w-4 text-center shrink-0"></i> Dashboard
        </a>
        <a href="{{ route('karyawan.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] text-white/55 hover:bg-white/[.07] hover:text-white transition-all">
            <i class="fas fa-users w-4 text-center shrink-0"></i> Data Karyawan
        </a>
        <a href="{{ route('kriteria.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] text-white/55 hover:bg-white/[.07] hover:text-white transition-all">
            <i class="fas fa-sliders-h w-4 text-center shrink-0"></i> Kriteria &amp; Bobot
        </a>

        {{-- GRUP: PENILAIAN --}}
        <p class="text-white/30 text-[10px] font-semibold tracking-widest uppercase px-2 pt-4 pb-1.5">Penilaian</p>

        <a href="{{ route('penilaian.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] text-white/55 hover:bg-white/[.07] hover:text-white transition-all">
            <i class="fas fa-star w-4 text-center shrink-0"></i> Input Penilaian
        </a>
        <a href="{{ route('penilaian.saw') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] text-white/55 hover:bg-white/[.07] hover:text-white transition-all">
            <i class="fas fa-calculator w-4 text-center shrink-0"></i> Perhitungan SAW
        </a>
        <a href="{{ route('hasil.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] text-white/55 hover:bg-white/[.07] hover:text-white transition-all">
            <i class="fas fa-trophy w-4 text-center shrink-0"></i> Hasil &amp; Ranking
        </a>

        {{-- GRUP: LAPORAN --}}
        <p class="text-white/30 text-[10px] font-semibold tracking-widest uppercase px-2 pt-4 pb-1.5">Laporan</p>

        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] text-white/55 hover:bg-white/[.07] hover:text-white transition-all">
            <i class="fas fa-history w-4 text-center shrink-0"></i> Riwayat Penilaian
        </a>
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13.5px] text-white/55 hover:bg-white/[.07] hover:text-white transition-all">
            <i class="fas fa-file-export w-4 text-center shrink-0"></i> Export Laporan
        </a>

    </nav>

    {{-- ===== PROFIL USER ===== --}}
    <div class="flex items-center gap-3 px-4 py-4 border-t border-white/[.07] shrink-0">
        <div
            class="w-9 h-9 rounded-xl bg-gradient-to-br from-coral to-orange-400
                    flex items-center justify-center font-heading font-bold text-white text-sm shrink-0">
            OW</div>
        <div class="flex-1 min-w-0">
            <p class="text-white text-[13px] font-medium truncate">Owner</p>
            <span class="text-white/40 text-[11px]">Administrator</span>
        </div>
        <a href="#" class="text-white/35 hover:text-coral transition-colors p-1" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>

</aside>
