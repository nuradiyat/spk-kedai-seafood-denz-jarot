<!--
|--------------------------------------------------------------------------
| auth/login.blade.html (versi non-PHP / static)
|--------------------------------------------------------------------------
| Halaman login sistem SPK.
| Fitur: Form username & password, validasi error, link lupa password.
| Layout: layouts/guest (latar ocean gradient + animasi bubble)
|
| NOTE:
| Semua sintaks Blade Laravel telah dihapus agar menjadi HTML statis.
|--------------------------------------------------------------------------
-->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SPK Denz Jarot</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-3xl shadow-2xl p-10 sm:p-12">

        {{-- ===== BRAND HEADER ===== --}}
        <div class="flex items-center gap-4 mb-8">
            <div
                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-ocean-deep to-ocean-surface
                    flex items-center justify-center text-2xl shrink-0">
                🐟</div>
            <div>
                <h1 class="font-syne font-bold text-ocean-deep text-lg leading-tight">
                    Denz Jarot Seafood
                </h1>
                <p class="text-slate-400 text-xs mt-0.5">Sistem Pendukung Keputusan</p>
            </div>
        </div>

        {{-- ===== JUDUL LOGIN ===== --}}
        <h2 class="font-syne font-bold text-ocean-deep text-2xl mb-1">Selamat Datang</h2>
        <p class="text-slate-400 text-sm mb-8">Masuk untuk mengelola penilaian karyawan</p>

        {{-- ===== ALERT ERROR (STATIC REPLACEMENT) ===== --}}
        <div class="mb-5 hidden flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
            <i class="fas fa-exclamation-circle text-red-400 mt-0.5 shrink-0"></i>
            <div>
                <p class="text-red-600 text-sm">Contoh error message</p>
            </div>
        </div>

        {{-- ===== FORM LOGIN ===== --}}
        <form method="POST" action="#">

            {{-- Input Username --}}
            <div class="mb-5">
                <label for="username" class="block text-sm font-semibold text-slate-600 mb-2">
                    Username
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                        <i class="fas fa-user"></i>
                    </span>
                    <input id="username" name="username" type="text" placeholder="Masukkan username"
                        autocomplete="username"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                              text-slate-900 text-sm focus:outline-none focus:border-seafoam focus:bg-white
                              transition-all duration-200"
                        required autofocus>
                </div>
            </div>

            {{-- Input Password --}}
            <div class="mb-7">
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="text-sm font-semibold text-slate-600">Password</label>
                    <a href="#"
                        class="text-xs text-seafoam hover:text-teal-600 hover:underline transition-colors">
                        Lupa password?
                    </a>
                </div>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" name="password" type="password" placeholder="Masukkan password"
                        autocomplete="current-password"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                              text-slate-900 text-sm focus:outline-none focus:border-seafoam focus:bg-white
                              transition-all duration-200"
                        required>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                class="w-full py-3.5 rounded-xl font-syne font-semibold text-white text-[15px]
                       bg-gradient-to-r from-ocean-deep to-ocean-surface tracking-wide
                       hover:-translate-y-0.5 hover:shadow-lg hover:shadow-ocean-deep/30
                       active:translate-y-0 transition-all duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Sistem
            </button>

        </form>

    </div>

</body>

</html>
