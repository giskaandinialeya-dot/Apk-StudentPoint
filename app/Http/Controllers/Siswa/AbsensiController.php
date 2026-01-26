<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Input absensi untuk hari ini
     */
    public function inputHariIni(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan']);
        }

        $validated = $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alfa',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Check if already input today
        $existingAbsensi = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($existingAbsensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah input absensi hari ini.'
            ]);
        }

        try {
            // Create absensi record
            $absensi = Absensi::create([
                'siswa_id' => $siswa->id,
                'guru_input_id' => $user->id, // Input sendiri oleh siswa (user_id)
                'tanggal' => today(),
                'status' => $validated['status'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Notify guru wali kelas
            if ($siswa->kelas && $siswa->kelas->waliGuru && $siswa->kelas->waliGuru->user_id) {
                Notifikasi::create([
                    'user_id' => $siswa->kelas->waliGuru->user_id,
                    'siswa_id' => $siswa->id,
                    'tipe' => 'absensi',
                    'judul' => 'Input Absensi: ' . ucfirst($validated['status']),
                    'deskripsi' => $siswa->nama_lengkap . ' telah input absensi hari ini dengan status ' . ucfirst($validated['status']) . '.',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil diinput! Guru Anda sudah mendapat notifikasi.',
                'status' => $validated['status']
            ]);
        } catch (\Exception $e) {
            \Log::error('Siswa Absensi Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lihat riwayat absensi
     */
    public function riwayat()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $absentis = Absensi::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('siswa.absensi.riwayat', [
            'absentis' => $absentis,
        ]);
    }
}
