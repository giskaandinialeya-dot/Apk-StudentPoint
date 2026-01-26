<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;

// Simulate guru1
$guruUser = User::where('email', 'guru1@epoin.com')->first();
echo "=== GURU DATA ===\n";
echo "User Email: {$guruUser->email}\n";
echo "User ID: {$guruUser->id}\n";

$guru = Guru::where('user_id', $guruUser->id)->first();
echo "Guru ID: {$guru->id}\n";
echo "Guru Kelas Wali ID: {$guru->kelas_wali_id}\n";

// Try loading relationship
echo "\nLading kelasWali relationship...\n";
$kelasWali = $guru->kelasWali;
echo "Kelas Wali loaded: " . ($kelasWali ? 'YES' : 'NO') . "\n";

if ($kelasWali) {
    echo "Kelas ID: {$kelasWali->id}\n";
    echo "Kelas Nama: {$kelasWali->nama}\n";
    
    echo "\nLoading siswas...\n";
    $siswas = $kelasWali->siswas()->aktif()->get();
    echo "Siswas count: {$siswas->count()}\n";
    foreach ($siswas as $s) {
        echo "  - {$s->nama_lengkap}\n";
    }
} else {
    echo "ERROR: Kelas wali not loaded!\n";
}
