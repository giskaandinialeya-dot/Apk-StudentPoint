<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\SuratPeringatan;
use App\Models\Notifikasi;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratPeringatanService
{
    /**
     * Check dan create surat peringatan otomatis berdasarkan poin pelanggaran
     */
    public static function checkAndCreateSuratPeringatan(Siswa $siswa)
    {
        $totalPoinPelanggaran = $siswa->total_poin_pelanggaran;

        // Cek threshold SP untuk setiap level
        for ($level = 1; $level <= 4; $level++) {
            $threshold = self::getThresholdForLevel($level);

            // Jika poin sudah melebihi threshold dan belum ada SP level ini
            if ($totalPoinPelanggaran >= $threshold) {
                // Cek apakah sudah ada SP level ini yang aktif
                $existingSP = SuratPeringatan::where('siswa_id', $siswa->id)
                    ->where('level', $level)
                    ->where('status', 'aktif')
                    ->first();

                if (!$existingSP) {
                    // Create SP baru
                    $sp = self::createSuratPeringatan($siswa, $level, $totalPoinPelanggaran);

                    // Create notifikasi untuk orang tua
                    self::notifyOrangTua($siswa, $sp);
                }
            }
        }
    }

    /**
     * Get threshold poin untuk setiap level SP
     * Bisa di-override dari setting sekolah nanti
     */
    public static function getThresholdForLevel($level)
    {
        $thresholds = [
            1 => 10,  // SP1 saat mencapai 10 poin
            2 => 20,  // SP2 saat mencapai 20 poin
            3 => 30,  // SP3 saat mencapai 30 poin
            4 => 40,  // SP4 saat mencapai 40 poin (dikeluarkan)
        ];

        return $thresholds[$level] ?? 50;
    }

    /**
     * Create surat peringatan
     */
    private static function createSuratPeringatan(Siswa $siswa, $level, $totalPoin)
    {
        $alasanTemplate = [
            1 => 'Siswa telah mencapai poin pelanggaran ' . $totalPoin . '. Berdasarkan peraturan sekolah, diberikan Surat Peringatan I.',
            2 => 'Siswa telah mencapai poin pelanggaran ' . $totalPoin . '. Berdasarkan peraturan sekolah, diberikan Surat Peringatan II.',
            3 => 'Siswa telah mencapai poin pelanggaran ' . $totalPoin . '. Berdasarkan peraturan sekolah, diberikan Surat Peringatan III.',
            4 => 'Siswa telah mencapai poin pelanggaran ' . $totalPoin . '. Berdasarkan peraturan sekolah, siswa dikeluarkan dari sekolah.',
        ];

        $sp = SuratPeringatan::create([
            'siswa_id' => $siswa->id,
            'level' => $level,
            'total_poin' => $totalPoin,
            'tanggal_terbit' => now()->toDateString(),
            'alasan' => $alasanTemplate[$level] ?? 'Pelanggaran disiplin',
            'status' => 'aktif',
        ]);

        // Generate PDF
        self::generatePDF($sp, $siswa);

        // Jika SP4, ubah status siswa menjadi nonaktif/dikeluarkan
        if ($level === 4) {
            $siswa->update(['status' => 'dikeluarkan']);
        }

        return $sp;
    }

    /**
     * Generate PDF surat peringatan
     */
    private static function generatePDF(SuratPeringatan $sp, Siswa $siswa)
    {
        try {
            $html = view('templates.surat-peringatan', [
                'sp' => $sp,
                'siswa' => $siswa,
            ])->render();

            $pdf = Pdf::loadHTML($html);
            $filename = 'SP' . $sp->level . '_' . $siswa->nis . '_' . now()->format('YmdHis') . '.pdf';
            $path = public_path('uploads/surat-peringatan/' . $filename);

            // Buat folder jika belum ada
            if (!is_dir(public_path('uploads/surat-peringatan'))) {
                mkdir(public_path('uploads/surat-peringatan'), 0755, true);
            }

            $pdf->save($path);
            $sp->update(['file_pdf' => 'uploads/surat-peringatan/' . $filename]);
        } catch (\Exception $e) {
            \Log::error('Error generate PDF SP: ' . $e->getMessage());
        }
    }

    /**
     * Notify orang tua tentang SP
     */
    private static function notifyOrangTua(Siswa $siswa, SuratPeringatan $sp)
    {
        $orangTuas = $siswa->orangTua()->get();

        foreach ($orangTuas as $orangTua) {
            // Skip if user_id is null
            if (!$orangTua->user_id) {
                continue;
            }
            
            Notifikasi::create([
                'user_id' => $orangTua->user_id,
                'siswa_id' => $siswa->id,
                'tipe' => 'surat_peringatan',
                'judul' => 'Surat Peringatan Diterima',
                'deskripsi' => 'Anak Anda ' . $siswa->nama_lengkap . ' telah menerima ' . $sp->level_label . ' pada tanggal ' . $sp->tanggal_terbit->format('d M Y') . '.',
            ]);
        }

        // Notify guru wali kelas
        if ($siswa->kelas && $siswa->kelas->waliGuru && $siswa->kelas->waliGuru->user_id) {
            Notifikasi::create([
                'user_id' => $siswa->kelas->waliGuru->user_id,
                'siswa_id' => $siswa->id,
                'tipe' => 'surat_peringatan',
                'judul' => 'Surat Peringatan Diterbitkan',
                'deskripsi' => $siswa->nama_lengkap . ' telah menerima ' . $sp->level_label . '.',
            ]);
        }
    }
}
