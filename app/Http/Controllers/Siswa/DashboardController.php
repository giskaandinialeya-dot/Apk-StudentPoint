<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\SuratPeringatan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard siswa
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        // Get pelanggaran dan prestasi today
        $todayPelanggarans = Pelanggaran::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->with('jenisPelanggaran')
            ->get();

        $todayPrestasis = Prestasi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->get();

        // Calculate totals
        $totalPelanggaranHari = $todayPelanggarans->sum(fn($p) => $p->jenisPelanggaran->poin ?? 0);
        $totalPrestasiHari = $todayPrestasis->sum('poin');

        // Status kehadiran hari ini
        $statusHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first()?->status;

        // Rekap bulanan
        $rekapBulanIni = [
            'hadir' => Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', now()->month)
                ->where('status', 'hadir')
                ->count(),
            'sakit' => Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', now()->month)
                ->where('status', 'sakit')
                ->count(),
            'izin' => Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', now()->month)
                ->where('status', 'izin')
                ->count(),
            'alfa' => Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', now()->month)
                ->where('status', 'alfa')
                ->count(),
        ];

        // Recent pelanggaran
        $recentPelanggarans = Pelanggaran::where('siswa_id', $siswa->id)
            ->with('jenisPelanggaran')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Recent prestasi
        $recentPrestasis = Prestasi::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        return view('siswa.dashboard', [
            'siswa' => $siswa,
            'totalPelanggaranHari' => $totalPelanggaranHari,
            'totalPrestasiHari' => $totalPrestasiHari,
            'statusHariIni' => $statusHariIni,
            'rekapBulanIni' => $rekapBulanIni,
            'recentPelanggarans' => $recentPelanggarans,
            'recentPrestasis' => $recentPrestasis,
        ]);
    }
}
