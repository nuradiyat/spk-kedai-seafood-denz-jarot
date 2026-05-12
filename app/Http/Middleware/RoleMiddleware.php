<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek role user
        if (Auth::user()->role !== $role) {

            // bisa pakai abort
            // abort(403, 'Akses ditolak');

            // atau redirect
            return redirect()->back()->with([
                'error' => 'Anda tidak memiliki akses ke halaman ini',
            ]);
        }

        return $next($request);
    }
}
