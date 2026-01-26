<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request dengan role checking
     * Usage: middleware(['role:admin,guru'])
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah user memiliki salah satu role yang required
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika role tidak sesuai, return 403
        return response()->view('errors.403', [], 403);
    }
}
