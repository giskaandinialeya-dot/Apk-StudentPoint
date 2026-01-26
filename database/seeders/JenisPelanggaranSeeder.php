<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisPerlanggaran;

class JenisPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        // Pelanggaran Ringan (1-3 poin)
        JenisPerlanggaran::create([
            'nama' => 'Terlambat Datang',
            'poin' => 1,
            'kategori' => 'ringan',
            'keterangan' => 'Terlambat datang ke sekolah maksimal 15 menit',
            'status' => 'aktif',
        ]);

        JenisPerlanggaran::create([
            'nama' => 'Tidak Mengerjakan PR',
            'poin' => 2,
            'kategori' => 'ringan',
            'keterangan' => 'Tidak mengumpulkan pekerjaan rumah',
            'status' => 'aktif',
        ]);

        JenisPerlanggaran::create([
            'nama' => 'Seragam Tidak Rapi',
            'poin' => 1,
            'kategori' => 'ringan',
            'keterangan' => 'Seragam tidak rapi atau tidak sesuai peraturan',
            'status' => 'aktif',
        ]);

        // Pelanggaran Sedang (4-10 poin)
        JenisPerlanggaran::create([
            'nama' => 'Bolos Kelas',
            'poin' => 5,
            'kategori' => 'sedang',
            'keterangan' => 'Tidak hadir di kelas tanpa surat izin',
            'status' => 'aktif',
        ]);

        JenisPerlanggaran::create([
            'nama' => 'Merusak Fasilitas Sekolah',
            'poin' => 7,
            'kategori' => 'sedang',
            'keterangan' => 'Merusak sarana dan prasarana sekolah',
            'status' => 'aktif',
        ]);

        JenisPerlanggaran::create([
            'nama' => 'Bermain Handphone di Kelas',
            'poin' => 4,
            'kategori' => 'sedang',
            'keterangan' => 'Menggunakan handphone di dalam kelas tanpa izin',
            'status' => 'aktif',
        ]);

        // Pelanggaran Berat (11+ poin)
        JenisPerlanggaran::create([
            'nama' => 'Menyontek Saat Ujian',
            'poin' => 15,
            'kategori' => 'berat',
            'keterangan' => 'Melakukan tindakan curang pada saat ujian',
            'auto_sp_level' => 1,
            'status' => 'aktif',
        ]);

        JenisPerlanggaran::create([
            'nama' => 'Terlibat Perkelahian',
            'poin' => 20,
            'kategori' => 'berat',
            'keterangan' => 'Terlibat dalam perkelahian dengan sesama siswa',
            'auto_sp_level' => 2,
            'status' => 'aktif',
        ]);

        JenisPerlanggaran::create([
            'nama' => 'Membawa Benda Terlarang',
            'poin' => 25,
            'kategori' => 'berat',
            'keterangan' => 'Membawa senjata, narkoba, atau benda berbahaya',
            'auto_sp_level' => 3,
            'status' => 'aktif',
        ]);

        JenisPerlanggaran::create([
            'nama' => 'Pelanggaran Moral/Etika',
            'poin' => 30,
            'kategori' => 'berat',
            'keterangan' => 'Melakukan tindakan amoral atau tidak etis',
            'auto_sp_level' => 3,
            'status' => 'aktif',
        ]);
    }
}
