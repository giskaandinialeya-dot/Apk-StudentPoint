<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect ke dashboard sesuai role user
     */
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
