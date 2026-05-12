{{--
================================================================
FILE    : layouts/app.blade.php
FUNGSI  : Layout utama semua halaman terautentikasi.
          Include: sidebar, navbar, footer, modals global, toast.
PAKAI   : @extends('layouts.app') di semua halaman pages/
================================================================
--}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK Bonus Karyawan') — Denz Jarot Seafood</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ocean': '#0a2540',
                        'ocean-md': '#163356',
                        'ocean-lt': '#1e4a7a',
                        'teal': '#00c896',
                        'teal-lt': '#00e6ab',
                        'teal-bg': '#e6fff8',
                        'coral': '#ff6b4a',
                        'sand': '#f5efe6',
                        'sand-dk': '#e8d9c4',
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        heading: ['Syne', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        .font-heading {
            font-family: 'Syne', sans-serif;
        }

        .sb-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sb-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sb-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .15);
            border-radius: 2px;
        }

        .nav-active {
            background: linear-gradient(135deg, rgba(0, 200, 150, .18), rgba(0, 200, 150, .06));
            border: 1px solid rgba(0, 200, 150, .25);
            color: #00e6ab !important;
        }

        .tbl-row:hover {
            background-color: #fafcff;
        }

        .cell-best {
            background: rgba(0, 200, 150, .1);
            color: #005533;
            font-weight: 600;
        }

        .bar {
            transition: width 1s ease;
        }

        sub {
            font-size: .68em;
        }

        @media print {
            .no-print {
                display: none !important
            }

            aside,
            header {
                display: none !important
            }

            .lg\:ml-64 {
                margin-left: 0 !important
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-100 min-h-screen text-slate-800">

    {{-- Mobile backdrop --}}
    <div id="backdrop" onclick="closeSidebar()" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">

            {{-- NAVBAR --}}
            @include('layouts.navbar')

            {{-- PAGE CONTENT --}}
            <main class="flex-1 p-4 lg:p-7">
                @include('components.alerts.success')
                @include('components.alerts.error')
                @yield('content')
            </main>

            {{-- FOOTER --}}
            @include('layouts.footer')
        </div>
    </div>

    {{-- GLOBAL MODALS --}}
    @include('components.modals.delete')
    @include('components.modals.export')

    {{-- TOAST --}}
    <div id="toast"
        class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 bg-ocean text-white
                px-5 py-3.5 rounded-2xl shadow-2xl translate-y-24 opacity-0 transition-all duration-300 pointer-events-none">
        <i class="fas fa-check-circle text-teal text-lg"></i>
        <span id="toastMsg" class="text-sm font-medium"></span>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('backdrop').classList.toggle('hidden');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('backdrop').classList.add('hidden');
        }

        function showToast(msg, dur = 3000) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            t.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                t.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                t.classList.remove('translate-y-0', 'opacity-100');
            }, dur);
        }

        function openDeleteModal(url, name) {
            document.getElementById('deleteTargetName').textContent = name;
            document.getElementById('deleteForm').setAttribute('action', url);
            document.getElementById('deleteModal').classList.replace('hidden', 'flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.replace('flex', 'hidden');
        }

        function openExportModal() {
            document.getElementById('exportModal').classList.replace('hidden', 'flex');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.replace('flex', 'hidden');
        }
    </script>

    @stack('scripts')
</body>

</html>
