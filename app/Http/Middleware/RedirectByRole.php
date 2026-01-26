<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectByRole
{
    /**
     * Redirect user ke dashboard sesuai role mereka
     * Digunakan setelah login berhasil
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Jika sudah di dashboard atau route yang protected, lanjut
            if ($request->is('dashboard*') || $request->is('guru*') || $request->is('siswa*') || $request->is('orang-tua*') || $request->is('admin*')) {
                return $next($request);
            }

            // Redirect ke halaman login jika user tidak authenticated
            return $next($request);
        }

        return $next($request);
    }
}
