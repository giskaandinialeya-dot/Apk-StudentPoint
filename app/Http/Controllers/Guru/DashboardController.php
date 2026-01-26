<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard guru dengan ringkasan real-time
     */
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        // Validasi guru memiliki kelas wali
        if (!$guru || !$guru->kelasWali) {
            return view('guru.dashboard-empty');
        }

        $kelas = $guru->kelasWali;
        $siswas = $kelas->siswas()->aktif()->get();

        // Statistik hari ini
        $pelangggaranHariIni = Pelanggaran::whereIn('siswa_id', $siswas->pluck('id'))
            ->whereDate('tanggal', today())
            ->count();

        $prestasiHariIni = Prestasi::whereIn('siswa_id', $siswas->pluck('id'))
            ->whereDate('tanggal', today())
            ->count();

        // Statistik kehadiran
        $totalAbsensiHariIni = Absensi::whereIn('siswa_id', $siswas->pluck('id'))
            ->whereDate('tanggal', today())
            ->count();

        $hadirHariIni = Absensi::whereIn('siswa_id', $siswas->pluck('id'))
            ->whereDate('tanggal', today())
            ->where('status', 'hadir')
            ->count();

        $persenKehadiran = $totalAbsensiHariIni > 0 
            ? round(($hadirHariIni / $totalAbsensiHariIni) * 100) 
            : 0;

        // Total poin per siswa
        $siswasWithPoints = $siswas->map(function ($siswa) {
            return [
                'id' => $siswa->id,
                'nama' => $siswa->nama_lengkap,
                'kelas' => $siswa->kelas->nama ?? 'Tidak Dikonfirmasi',
                'poin_pelanggaran' => $siswa->total_poin_pelanggaran,
                'poin_prestasi' => $siswa->total_poin_prestasi,
                'saldo_poin' => $siswa->saldo_poin,
            ];
        })->sortBy('saldo_poin')->values();

        // Recent activity: 10 pelanggaran & prestasi terbaru
        $recentActivity = collect()
            ->concat(
                Pelanggaran::whereIn('siswa_id', $siswas->pluck('id'))
                    ->with('siswa', 'jenisPelanggaran')
                    ->orderBy('tanggal', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(fn($p) => [
                        'type' => 'pelanggaran',
                        'siswa' => $p->siswa->nama_lengkap,
                        'deskripsi' => $p->jenisPelanggaran->nama . ' (' . $p->jenisPelanggaran->poin . ' poin)',
                        'tanggal' => $p->tanggal->format('d M Y H:i'),
                    ])
            )
            ->concat(
                Prestasi::whereIn('siswa_id', $siswas->pluck('id'))
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(fn($p) => [
                        'type' => 'prestasi',
                        'siswa' => $p->siswa->nama_lengkap,
                        'deskripsi' => $p->nama_prestasi . ' (' . $p->poin . ' poin)',
                        'tanggal' => $p->tanggal->format('d M Y'),
                    ])
            )
            ->sortByDesc('tanggal')
            ->values()
            ->take(10);

        // Siswa dengan poin kritis (akan kena SP)
        $siswasKritis = $siswasWithPoints->filter(fn($s) => $s['poin_pelanggaran'] >= 10);

        // Data chart: tren poin bulanan
        $trendData = $this->getTrendDataMulanan($siswas->pluck('id'));

        return view('guru.dashboard', [
            'kelas' => $kelas,
            'jumlahSiswa' => $siswas->count(),
            'pelanggaran_hari_ini' => $pelangggaranHariIni,
            'prestasi_hari_ini' => $prestasiHariIni,
            'persen_kehadiran' => $persenKehadiran,
            'siswas_with_points' => $siswasWithPoints,
            'siswa_kritis' => $siswasKritis,
            'recent_activity' => $recentActivity,
            'trend_data' => $trendData,
        ]);
    }

    /**
     * Helper: Get data tren poin bulanan
     */
    private function getTrendDataMulanan($siswaIds)
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push([
                'bulan' => $date->format('M Y'),
                'pelanggaran' => Pelanggaran::whereIn('siswa_id', $siswaIds)
                    ->whereMonth('tanggal', $date->month)
                    ->whereYear('tanggal', $date->year)
                    ->count(),
                'prestasi' => Prestasi::whereIn('siswa_id', $siswaIds)
                    ->whereMonth('tanggal', $date->month)
                    ->whereYear('tanggal', $date->year)
                    ->count(),
            ]);
        }

        return $months;
    }
}
