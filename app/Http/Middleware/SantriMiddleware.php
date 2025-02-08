<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SantriMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user telah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Cek apakah user adalah santri
        if (Auth::user()->role !== 'santri') {
            return abort(403, 'Anda tidak memiliki hak akses untuk halaman ini!');
        }

        return $next($request);
    }
}
