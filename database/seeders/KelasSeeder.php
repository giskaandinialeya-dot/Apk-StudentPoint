<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        Kelas::create([
            'nama' => 'X IPA 1',
            'tingkat' => 'X',
            'wali_guru_id' => 1,
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'tahun_kelulusan' => 2027,
            'status' => 'aktif',
        ]);

        Kelas::create([
            'nama' => 'X IPA 2',
            'tingkat' => 'X',
            'wali_guru_id' => 2,
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'tahun_kelulusan' => 2027,
            'status' => 'aktif',
        ]);

        Kelas::create([
            'nama' => 'X IPS 1',
            'tingkat' => 'X',
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'tahun_kelulusan' => 2027,
            'status' => 'aktif',
        ]);

        Kelas::create([
            'nama' => 'XI IPA 1',
            'tingkat' => 'XI',
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'tahun_kelulusan' => 2026,
            'status' => 'aktif',
        ]);
    }
}
