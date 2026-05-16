{{-- 
================================================================
FILE    : layouts/navbar.blade.php
FUNGSI  : Loader navbar berdasarkan role user.
================================================================
--}}

@if (auth()->user()->role == 'admin')
    @include('roles.admin.navbar')
@elseif(auth()->user()->role == 'owner')
    @include('roles.owner.navbar')
@endif
