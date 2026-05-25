{{-- =========================================================
FILE    : layouts/sidebar.blade.php
FUNGSI  : Memanggil sidebar berdasarkan role user
========================================================= --}}

@if (auth()->user()->role == 'admin')
    @include('roles.admin.sidebar')
@elseif(auth()->user()->role == 'owner')
    @include('roles.owner.sidebar')
@endif
