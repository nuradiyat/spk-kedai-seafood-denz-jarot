{{--
================================================================
FILE    : components/alerts/error.blade.php
FUNGSI  : Komponen alert notifikasi error/validasi (dummy/statis).
          Di production: tampil via session('error') atau $errors.
================================================================
--}}

@if (session('error') || $errors->any())
<div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200
            text-red-700 rounded-xl px-4 py-3 text-sm">
    <i class="fas fa-exclamation-circle text-red-400 mt-0.5 shrink-0"></i>
    <div class="flex-1">
        @if (session('error')) <p>{{ session('error') }}</p> @endif
        @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
    </div>
    <button onclick="this.parentElement.remove()" class="text-red-300 hover:text-red-500">
        <i class="fas fa-times text-xs"></i>
    </button>
</div>
@endif

