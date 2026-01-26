<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show()
    {
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        return view('siswa.profil.show', compact('siswa'));
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        return view('siswa.profil.edit', compact('siswa'));
    }

    /**
     * Update the user's profile
     */
    public function update(\Illuminate\Http\Request $request)
    {
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
        ]);

        $siswa->update($validated);

        // Update user name
        Auth::user()->update(['name' => $validated['nama_lengkap']]);

        return redirect()->route('siswa.profil.show')->with('success', 'Profil berhasil diperbarui');
    }
}
