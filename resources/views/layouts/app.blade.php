<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ocean: '#0F172A',
                        'ocean-lt': '#1E293B',
                        teal: '#14B8A6',
                        sand: '#F8FAFC',
                    }
                }
            }
        }
    </script>

</head>

<body class="bg-slate-100 min-h-screen">

    <div class="flex">

        {{-- SIDEBAR --}}
        <aside class="w-72 min-h-screen bg-ocean text-white p-6">

            <div class="mb-10">

                <h1 class="text-2xl font-bold">
                    🐟 Denz Jarot
                </h1>

                <p class="text-slate-300 text-sm mt-1">
                    Sistem Pendukung Keputusan
                </p>

            </div>

            <nav class="space-y-3">

                <a href="/dashboard"
                   class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">

                    Dashboard

                </a>

                @if(auth()->user()->role == 'admin')

                <a href="/karyawan"
                   class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">

                    Data Karyawan

                </a>

                <a href="/kriteria"
                   class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">

                    Data Kriteria

                </a>

                <a href="/penilaian"
                   class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">

                    Penilaian

                </a>

                @endif

                <a href="/hasil"
                   class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">

                    Hasil SAW

                </a>

                <a href="/riwayat"
                   class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">

                    Riwayat

                </a>

                <form action="{{ route('logout') }}"
                      method="POST"
                      class="pt-6">

                    @csrf

                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600
                                   py-3 rounded-xl transition">

                        Logout

                    </button>

                </form>

            </nav>

        </aside>

        {{-- CONTENT --}}
        <main class="flex-1 p-8">

            @yield('content')

        </main>

    </div>

</body>
</html>