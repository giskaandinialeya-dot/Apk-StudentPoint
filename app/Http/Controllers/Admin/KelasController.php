<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with('guru')
                      ->withCount('siswas');

        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kelas_list = $query->orderBy('nama')->paginate(15);

        return view('admin.kelas.index', ['kelas_list' => $kelas_list]);
    }

    public function create()
    {
        $guru_list = Guru::where('status', 'aktif')->get();
        return view('admin.kelas.create', ['guru_list' => $guru_list]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:kelas,nama',
            'wali_guru_id' => 'required|exists:gurus,id',
            'ruang' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Ambil user_id dari guru yang dipilih
        $guru = Guru::find($validated['wali_guru_id']);
        $validated['wali_guru_id'] = $guru->user_id;

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
                       ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit(Kelas $kelas)
    {
        $guru_list = Guru::where('status', 'aktif')->get();
        $siswa_count = $kelas->siswas()->count();
        return view('admin.kelas.edit', [
            'kelas' => $kelas,
            'guru_list' => $guru_list,
            'siswa_count' => $siswa_count,
        ]);
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:kelas,nama,' . $kelas->id,
            'wali_guru_id' => 'required|exists:gurus,id',
            'ruang' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')
                       ->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
                       ->with('success', 'Kelas berhasil dihapus!');
    }
}
