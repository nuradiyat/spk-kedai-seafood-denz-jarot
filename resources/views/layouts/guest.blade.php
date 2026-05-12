{{--
================================================================
FILE    : layouts/guest.blade.php
FUNGSI  : Layout untuk halaman publik (login, forgot password).
          Latar ocean gradient + animasi gelembung dekoratif.
PAKAI   : @extends('layouts.guest')
================================================================
--}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('halaman')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ocean': '#0a2540',
                        'ocean-lt': '#1e4a7a',
                        'teal': '#00c896',
                        'sand': '#f5efe6'
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        heading: ['Syne', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        .font-heading {
            font-family: 'Syne', sans-serif;
        }

        /* Animasi gelembung latar belakang */
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 200, 150, .12);
            animation: floatUp 6s ease-in-out infinite;
        }

        @keyframes floatUp {

            0%,
            100% {
                transform: translateY(0) scale(1)
            }

            50% {
                transform: translateY(-22px) scale(1.06)
            }
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-[#0a2540] via-[#1e4a7a] to-teal-700
             flex items-center justify-center relative overflow-hidden">

    {{-- ===== DEKORASI GELEMBUNG ===== --}}
    <div class="bubble w-20 h-20  top-[8%]    left-[4%]" style="animation-delay:0s"></div>
    <div class="bubble w-12 h-12  top-[28%]   right-[7%]" style="animation-delay:1.2s"></div>
    <div class="bubble w-32 h-32  bottom-[18%] left-[12%]" style="animation-delay:2.5s"></div>
    <div class="bubble w-10 h-10  top-[58%]   right-[18%]" style="animation-delay:0.7s"></div>
    <div class="bubble w-16 h-16  bottom-[8%] right-[8%]" style="animation-delay:1.8s"></div>

    {{-- Gelombang bawah --}}
    <svg class="absolute bottom-0 left-0 right-0 opacity-10 pointer-events-none" viewBox="0 0 1440 180"
        preserveAspectRatio="none">
        <path d="M0,90 C300,150 480,30 720,70 C960,110 1100,150 1440,90 L1440,180 L0,180 Z" fill="white" />
    </svg>

    {{-- ===== KONTEN HALAMAN ===== --}}
    <div class="relative z-10 w-full max-w-md mx-4">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
