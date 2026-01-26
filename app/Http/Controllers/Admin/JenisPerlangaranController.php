<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPerlanggaran;
use Illuminate\Http\Request;

class JenisPerlangaranController extends Controller
{
    public function index(Request $request)
    {
        $query = JenisPerlanggaran::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('keterangan', 'like', "%{$request->search}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jenis_list = $query->orderBy('nama')->paginate(15);

        return view('admin.jenis-pelanggaran.index', [
            'jenis_list' => $jenis_list,
            'kategori_options' => JenisPerlanggaran::KATEGORI,
        ]);
    }

    public function create()
    {
        return view('admin.jenis-pelanggaran.create', [
            'kategori_options' => JenisPerlanggaran::KATEGORI,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_pelanggarans,nama',
            'poin' => 'required|integer|min:1|max:100',
            'kategori' => 'required|in:ringan,sedang,berat',
            'keterangan' => 'nullable|string',
            'auto_sp_level' => 'nullable|integer|min:1|max:3',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        JenisPerlanggaran::create($validated);

        return redirect()->route('admin.jenis-pelanggaran.index')
                       ->with('success', 'Jenis pelanggaran berhasil ditambahkan!');
    }

    public function edit(JenisPerlanggaran $jenis_pelanggaran)
    {
        return view('admin.jenis-pelanggaran.edit', [
            'jenis' => $jenis_pelanggaran,
            'kategori_options' => JenisPerlanggaran::KATEGORI,
        ]);
    }

    public function update(Request $request, JenisPerlanggaran $jenis_pelanggaran)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_pelanggarans,nama,' . $jenis_pelanggaran->id,
            'poin' => 'required|integer|min:1|max:100',
            'kategori' => 'required|in:ringan,sedang,berat',
            'keterangan' => 'nullable|string',
            'auto_sp_level' => 'nullable|integer|min:1|max:3',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $jenis_pelanggaran->update($validated);

        return redirect()->route('admin.jenis-pelanggaran.index')
                       ->with('success', 'Jenis pelanggaran berhasil diperbarui!');
    }

    public function destroy(JenisPerlanggaran $jenis_pelanggaran)
    {
        $jenis_pelanggaran->delete();

        return redirect()->route('admin.jenis-pelanggaran.index')
                       ->with('success', 'Jenis pelanggaran berhasil dihapus!');
    }
}
