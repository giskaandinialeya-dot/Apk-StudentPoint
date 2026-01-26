<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\JenisPerlanggaran;
use App\Models\Guru;
use App\Models\User;

// Simulate guru1 login
$guruUser = User::where('email', 'guru1@epoin.com')->first();
echo "=== SIMULASI CREATE FORM ===\n";
echo "Guru User: {$guruUser->name}\n";

$guru = Guru::where('user_id', $guruUser->id)->first();
echo "Guru ID: {$guru->id}\n";
echo "Kelas Wali ID: {$guru->kelasWali?->id}\n";

$siswas = $guru->kelasWali->siswas()->aktif()->get();
echo "Jumlah Siswa: {$siswas->count()}\n";
foreach ($siswas as $s) {
    echo "  - {$s->nama_lengkap}\n";
}

$jenisPelanggarans = JenisPerlanggaran::aktif()->get();
echo "\nJumlah Jenis Pelanggaran Aktif: {$jenisPelanggarans->count()}\n";
foreach ($jenisPelanggarans as $j) {
    echo "  - {$j->nama}\n";
}

echo "\n✓ Data semua ada!\n";
