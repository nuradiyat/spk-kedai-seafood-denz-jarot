<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek role user
        if (auth()->user()->role !== $role) {

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
