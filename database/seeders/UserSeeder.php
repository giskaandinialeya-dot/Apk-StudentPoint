<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin E-POIN',
            'email' => 'admin@epoin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Guru 1 (Wali Kelas)
        $user_guru1 = User::create([
            'name' => 'Budi Santoso, S.Pd.',
            'email' => 'guru1@epoin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        Guru::create([
            'user_id' => $user_guru1->id,
            'nip' => '198505152010011001',
            'nama_lengkap' => 'Budi Santoso, S.Pd.',
            'jenis_kelamin' => 'laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1985-05-15',
            'agama' => 'Islam',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'spesialisasi' => 'Matematika',
            'status' => 'aktif',
        ]);

        // Guru 2
        $user_guru2 = User::create([
            'name' => 'Siti Rahma, S.Pd.',
            'email' => 'guru2@epoin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        Guru::create([
            'user_id' => $user_guru2->id,
            'nip' => '199012082015032002',
            'nama_lengkap' => 'Siti Rahma, S.Pd.',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1990-12-08',
            'agama' => 'Islam',
            'alamat' => 'Jl. Sudirman No. 456, Bandung',
            'spesialisasi' => 'Bahasa Indonesia',
            'status' => 'aktif',
        ]);

        // Siswa 1
        User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'siswa1@epoin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'is_active' => true,
        ]);

        // Siswa 2
        User::create([
            'name' => 'Nur Azizah',
            'email' => 'siswa2@epoin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'is_active' => true,
        ]);

        // Siswa 3
        User::create([
            'name' => 'Rina Wijaya',
            'email' => 'siswa3@epoin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'is_active' => true,
        ]);
    }
}

