<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $guru_list = $query->orderBy('nama_lengkap')->paginate(15);

        return view('admin.guru.index', ['guru_list' => $guru_list]);
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'spesialisasi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'guru',
        ]);

        // Create guru
        Guru::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'spesialisasi' => $validated['spesialisasi'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.guru.index')
                       ->with('success', 'Guru berhasil ditambahkan!');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', ['guru' => $guru]);
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'spesialisasi' => 'nullable|string',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
            $guru->user->update(['password' => $validated['password']]);
        }

        $guru->update($validated);
        $guru->user->update(['email' => $validated['email']]);

        return redirect()->route('admin.guru.index')
                       ->with('success', 'Guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        $guru->user->delete();
        $guru->delete();

        return redirect()->route('admin.guru.index')
                       ->with('success', 'Guru berhasil dihapus!');
    }
}
