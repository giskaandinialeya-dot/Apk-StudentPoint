<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
    /**
     * Display listing prestasi
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $guru = \App\Models\Guru::where('user_id', $user->id)->first();

        $query = Prestasi::with(['siswa', 'guruInput']);

        // Filter berdasarkan kelas wali jika guru adalah wali kelas
        if ($guru && $guru->kelasWali) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $guru->kelasWali->id));
        } else {
            // Guru biasa hanya bisa lihat prestasi yang dia input
            $query->where('guru_input_id', $user->id);
        }

        // Filter tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter siswa
        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $prestasis = $query->orderBy('tanggal', 'desc')->paginate(15);

        $daftarSiswa = $guru && $guru->kelasWali
            ? $guru->kelasWali->siswas()->aktif()->get()
            : collect();

        return view('guru.prestasi.index', [
            'prestasis' => $prestasis,
            'daftar_siswa' => $daftarSiswa,
        ]);
    }

    /**
     * Show form create prestasi
     */
    public function create()
    {
        $user = Auth::user();
        $guru = \App\Models\Guru::where('user_id', $user->id)->first();

        if (!$guru || !$guru->kelasWali) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas wali.');
        }

        $siswas = $guru->kelasWali->siswas()->aktif()->get();

        return view('guru.prestasi.create', [
            'siswas' => $siswas,
        ]);
    }

    /**
     * Store prestasi
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kategori' => 'required|in:akademik,non-akademik',
            'poin' => 'required|integer|min:1|max:100',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:500',
            'bukti_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        // Store single prestasi
        $prestasi = new Prestasi([
            'siswa_id' => $validated['siswa_id'],
            'guru_input_id' => $user->id,
            'kategori' => $validated['kategori'],
            'poin' => $validated['poin'],
            'tanggal' => $validated['tanggal'],
            'deskripsi' => $validated['deskripsi'],
            'status' => 'aktif',
        ]);

        // Handle file upload
        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/prestasi'), $filename);
            $prestasi->bukti_file = 'uploads/prestasi/' . $filename;
        }

        $prestasi->save();

        return redirect()->route('guru.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan');
    }

    /**
     * Edit prestasi
     */
    public function edit(Prestasi $prestasi)
    {
        $user = Auth::user();
        if ($prestasi->guru_input_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return view('guru.prestasi.edit', [
            'prestasi' => $prestasi,
        ]);
    }

    /**
     * Update prestasi
     */
    public function update(Request $request, Prestasi $prestasi)
    {
        $user = Auth::user();
        if ($prestasi->guru_input_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'kategori' => 'required|in:akademik,non-akademik',
            'poin' => 'required|integer|min:1|max:100',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:500',
            'bukti_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        $prestasi->update($validated);

        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/prestasi'), $filename);
            $prestasi->update(['bukti_file' => 'uploads/prestasi/' . $filename]);
        }

        return redirect()->route('guru.prestasi.index')
            ->with('success', 'Prestasi berhasil diubah');
    }

    /**
     * Delete prestasi
     */
    public function destroy(Prestasi $prestasi)
    {
        $user = Auth::user();
        if ($prestasi->guru_input_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $prestasi->delete();

        return redirect()->route('guru.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus');
    }
}
