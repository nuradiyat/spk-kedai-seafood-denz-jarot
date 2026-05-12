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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        /**
         * =========================
         * CEK LOGIN
         * =========================
         */
        if (!auth()->check()) {

            return redirect()->route('login');
        }

        /**
         * =========================
         * CEK ROLE
         * =========================
         */
        if (!in_array(auth()->user()->role, $roles)) {

            return redirect()
                ->route('dashboard')
                ->with('error', 'Akses ditolak');
        }

        return $next($request);
    }
}