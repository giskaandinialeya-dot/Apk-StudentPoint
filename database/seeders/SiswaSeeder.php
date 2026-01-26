<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\OrangTua;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Siswa 1
        Siswa::create([
            'user_id' => 4,  // siswa1@epoin.com
            'nis' => '10001',
            'nama_lengkap' => 'Ahmad Fauzi',
            'jenis_kelamin' => 'laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2007-03-15',
            'agama' => 'Islam',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'kelas_id' => 1,
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'status' => 'aktif',
            'tanggal_masuk' => '2021-07-15',
        ]);

        // Siswa 2
        Siswa::create([
            'user_id' => 5,  // siswa2@epoin.com
            'nis' => '10002',
            'nama_lengkap' => 'Nur Azizah',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2007-07-20',
            'agama' => 'Islam',
            'alamat' => 'Jl. Sudirman No. 456, Bandung',
            'kelas_id' => 1,
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'status' => 'aktif',
            'tanggal_masuk' => '2021-07-15',
        ]);

        // Siswa 3
        Siswa::create([
            'user_id' => 6,  // siswa3@epoin.com
            'nis' => '10003',
            'nama_lengkap' => 'Rina Wijaya',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2007-11-10',
            'agama' => 'Kristen',
            'alamat' => 'Jl. Gatot Subroto No. 789, Surabaya',
            'kelas_id' => 1,
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'status' => 'aktif',
            'tanggal_masuk' => '2021-07-15',
        ]);

        // Orang Tua Siswa 1
        OrangTua::create([
            'user_id' => 7,  // ortu1@epoin.com
            'siswa_id' => 1,
            'hubungan' => 'ayah',
            'nama_lengkap' => 'Hendra Fauzi',
            'jenis_kelamin' => 'laki-laki',
            'pekerjaan' => 'Pegawai Swasta',
            'nomor_telepon' => '081234567890',
            'email_pribadi' => 'hendra@mail.com',
            'status' => 'aktif',
        ]);

        // Orang Tua Siswa 2
        OrangTua::create([
            'user_id' => 8,  // ortu2@epoin.com
            'siswa_id' => 2,
            'hubungan' => 'ibu',
            'nama_lengkap' => 'Ratna Wijaya',
            'jenis_kelamin' => 'perempuan',
            'pekerjaan' => 'Guru',
            'nomor_telepon' => '081345678901',
            'email_pribadi' => 'ratna@mail.com',
            'status' => 'aktif',
        ]);
    }
}
