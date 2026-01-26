<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\Siswa;

// Update siswa Aleya ke kelas X IPA 2 (kelas_id = 2)
$aleyaUser = User::where('email', 'Aleya@gmail.com')->first();
if ($aleyaUser) {
    $siswa = Siswa::where('user_id', $aleyaUser->id)->first();
    if ($siswa) {
        echo "Before:\n";
        echo "  Siswa: {$siswa->nama_lengkap}\n";
        echo "  Kelas ID: {$siswa->kelas_id}\n";
        echo "  Kelas Nama: {$siswa->kelas?->nama}\n";
        
        // Update ke kelas X IPA 2 (ID = 2)
        $siswa->update(['kelas_id' => 2]);
        $siswa->refresh();
        
        echo "\nAfter:\n";
        echo "  Siswa: {$siswa->nama_lengkap}\n";
        echo "  Kelas ID: {$siswa->kelas_id}\n";
        echo "  Kelas Nama: {$siswa->kelas?->nama}\n";
        echo "\n✓ Siswa berhasil dipindahkan ke kelas {$siswa->kelas?->nama}!\n";
    } else {
        echo "❌ Siswa tidak ditemukan\n";
    }
} else {
    echo "❌ User Aleya@gmail.com tidak ditemukan\n";
}
