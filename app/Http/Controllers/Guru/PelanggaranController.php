<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\JenisPerlanggaran;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    /**
     * Display listing pelanggaran
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $guru = \App\Models\Guru::where('user_id', $user->id)->first();

        $query = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guruInput']);

        // Filter berdasarkan kelas wali jika guru adalah wali kelas
        if ($guru && $guru->kelasWali) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $guru->kelasWali->id));
        } else {
            // Guru biasa hanya bisa lihat pelanggaran yang dia input
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

        // Filter jenis pelanggaran
        if ($request->filled('jenis_pelanggaran_id')) {
            $query->where('jenis_pelanggaran_id', $request->jenis_pelanggaran_id);
        }

        $pelanggarans = $query->orderBy('tanggal', 'desc')->paginate(15);

        $daftarSiswa = $guru && $guru->kelasWali
            ? $guru->kelasWali->siswas()->aktif()->get()
            : collect();

        $jenisPelanggarans = JenisPerlanggaran::aktif()->get();

        return view('guru.pelanggaran.index', [
            'pelanggarans' => $pelanggarans,
            'daftar_siswa' => $daftarSiswa,
            'jenis_pelanggarans' => $jenisPelanggarans,
        ]);
    }

    /**
     * Show form create pelanggaran
     */
    public function create()
    {
        $user = Auth::user();
        \Log::info('PelanggaranController@create - User: ' . $user->id . ' (' . $user->email . ')');
        
        $guru = \App\Models\Guru::where('user_id', $user->id)->first();
        \Log::info('PelanggaranController@create - Guru found: ' . ($guru ? 'YES' : 'NO'));

        if (!$guru || !$guru->kelasWali) {
            \Log::warning('PelanggaranController@create - No guru or no kelas wali');
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas wali.');
        }

        $siswas = $guru->kelasWali->siswas()->aktif()->get();
        $jenisPelanggarans = JenisPerlanggaran::aktif()->orderBy('nama')->get();
        
        \Log::info('PelanggaranController@create - Siswas count: ' . $siswas->count());
        \Log::info('PelanggaranController@create - Jenis Pelanggaran count: ' . $jenisPelanggarans->count());

        return view('guru.pelanggaran.create', [
            'siswas' => $siswas,
            'jenis_pelanggarans' => $jenisPelanggarans,
        ]);
    }

    /**
     * Store pelanggaran
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggarans,id',
            'tanggal' => 'required|date',
            'jam' => 'nullable|date_format:H:i',
            'deskripsi' => 'nullable|string',
            'bukti_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        // Store single pelanggaran
        $pelanggaran = new Pelanggaran([
            'siswa_id' => $validated['siswa_id'],
            'guru_input_id' => $user->id,
            'jenis_pelanggaran_id' => $validated['jenis_pelanggaran_id'],
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

            // Handle file upload

        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukti'), $filename);
            $pelanggaran->bukti_file = 'uploads/bukti/' . $filename;
        }

        $pelanggaran->save();

        return redirect()->route('guru.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil ditambahkan');
    }

    /**
     * Edit pelanggaran
     */
    public function edit(Pelanggaran $pelanggaran)
    {
        $user = Auth::user();
        if ($pelanggaran->guru_input_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $jenisPelanggarans = JenisPerlanggaran::aktif()->get();

        return view('guru.pelanggaran.edit', [
            'pelanggaran' => $pelanggaran,
            'jenis_pelanggarans' => $jenisPelanggarans,
        ]);
    }

    /**
     * Update pelanggaran
     */
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $user = Auth::user();
        if ($pelanggaran->guru_input_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggarans,id',
            'tanggal' => 'required|date',
            'jam' => 'nullable|date_format:H:i',
            'deskripsi' => 'nullable|string',
            'bukti_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        $pelanggaran->update($validated);

        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukti'), $filename);
            $pelanggaran->update(['bukti_file' => 'uploads/bukti/' . $filename]);
        }

        return redirect()->route('guru.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil diubah');
    }

    /**
     * Delete pelanggaran
     */
    public function destroy(Pelanggaran $pelanggaran)
    {
        $user = Auth::user();
        if ($pelanggaran->guru_input_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        // Get siswa before delete
        $siswa = $pelanggaran->siswa;
        $jenisPoin = $pelanggaran->jenisPerlanggaran->poin ?? 0;

        // Force delete pelanggaran (bypass soft delete)
        $pelanggaran->forceDelete();

        // Reduce siswa's poin_pelanggaran
        if ($siswa && $jenisPoin > 0) {
            $siswa->decrement('poin_pelanggaran', $jenisPoin);
        }

        return redirect()->route('guru.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dihapus dan poin siswa telah dikurangi');
    }

    /**
     * Quick add jenis pelanggaran custom by guru
     */
    public function quickAddJenis(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'poin' => 'required|integer|min:1|max:100',
            'kategori' => 'required|in:ringan,sedang,berat',
        ]);

        // Create custom jenis pelanggaran with guru as creator
        $jenisPelanggaran = JenisPerlanggaran::create([
            'nama' => $validated['nama'],
            'poin' => $validated['poin'],
            'kategori' => $validated['kategori'],
            'keterangan' => 'Dibuat oleh guru',
            'aktif' => true,
            'created_by' => $user->id, // Track who created it
        ]);

        return response()->json([
            'success' => true,
            'id' => $jenisPelanggaran->id,
            'nama' => $jenisPelanggaran->nama,
            'poin' => $jenisPelanggaran->poin,
            'message' => 'Jenis pelanggaran berhasil ditambahkan'
        ]);
    }
}

