{{--
================================================================
FILE    : components/alerts/success.blade.php
FUNGSI  : Komponen alert notifikasi sukses (dummy/statis).
          Di production: tampil via session('success').
================================================================
--}}
@if (session('success'))
    <div
        class="mb-5 flex items-center gap-3 bg-teal-bg border border-teal-200
            text-teal-800 rounded-xl px-4 py-3 text-sm">
        <i class="fas fa-check-circle text-teal shrink-0"></i>
        <span class="flex-1">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-teal-400 hover:text-teal-600">
            <i class="fas fa-times text-xs"></i>
        </button>
    </div>
@endif
