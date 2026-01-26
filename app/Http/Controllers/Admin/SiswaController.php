<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'kelas', 'orangTua']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $siswas = $query->orderBy('nama_lengkap')->paginate(15);
        $kelas_list = Kelas::aktif()->get();

        return view('admin.siswa.index', [
            'siswas' => $siswas,
            'kelas_list' => $kelas_list,
        ]);
    }

    public function create()
    {
        $kelas_list = Kelas::aktif()->get();
        return view('admin.siswa.create', ['kelas_list' => $kelas_list]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'siswa',
        ]);

        // Create siswa
        Siswa::create([
            'user_id' => $user->id,
            'nis' => $validated['nis'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'kelas_id' => $validated['kelas_id'],
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.siswa.index')
                       ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        $kelas_list = Kelas::aktif()->get();
        return view('admin.siswa.edit', [
            'siswa' => $siswa,
            'kelas_list' => $kelas_list,
        ]);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $siswa->update($validated);
        $siswa->user->update(['email' => $validated['email']]);

        return redirect()->route('admin.siswa.index')
                       ->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete();
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
                       ->with('success', 'Siswa berhasil dihapus!');
    }
}
