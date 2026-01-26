<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;

// Cek guru Budi
$guruUser = User::where('email', 'guru1@epoin.com')->first();
echo "=== GURU BUDI ===\n";
if ($guruUser) {
    echo "User ID: {$guruUser->id}\n";
    echo "Email: {$guruUser->email}\n";
    echo "Name: {$guruUser->name}\n";
    
    $guru = Guru::where('user_id', $guruUser->id)->first();
    if ($guru) {
        echo "Guru ID: {$guru->id}\n";
        echo "Kelas Wali ID: {$guru->kelasWali?->id}\n";
        echo "Kelas Wali Nama: {$guru->kelasWali?->nama}\n";
        
        if ($guru->kelasWali) {
            $siswas = $guru->kelasWali->siswas()->aktif()->get();
            echo "Jumlah Siswa di Kelas: {$siswas->count()}\n";
            foreach ($siswas as $siswa) {
                echo "  - {$siswa->nama_lengkap} (NIS: {$siswa->nis})\n";
            }
        }
    } else {
        echo "Guru record tidak ditemukan\n";
    }
} else {
    echo "User guru1@epoin.com tidak ditemukan\n";
}

echo "\n=== SISWA ALEYA ===\n";
$aleyaUser = User::where('email', 'Aleya@gmail.com')->first();
if ($aleyaUser) {
    echo "User ID: {$aleyaUser->id}\n";
    echo "Email: {$aleyaUser->email}\n";
    echo "Name: {$aleyaUser->name}\n";
    
    $siswa = Siswa::where('user_id', $aleyaUser->id)->first();
    if ($siswa) {
        echo "Siswa ID: {$siswa->id}\n";
        echo "NIS: {$siswa->nis}\n";
        echo "Kelas ID: {$siswa->kelas_id}\n";
        echo "Kelas Nama: {$siswa->kelas?->nama}\n";
        echo "Status: {$siswa->status}\n";
        
        if ($siswa->kelas) {
            echo "Kelas Wali Guru ID: {$siswa->kelas->wali_guru_id}\n";
        }
    } else {
        echo "Siswa record tidak ditemukan\n";
    }
} else {
    echo "User Aleya@gmail.com tidak ditemukan\n";
}

echo "\n=== SEMUA KELAS ===\n";
$kelas_list = Kelas::all();
foreach ($kelas_list as $kelas) {
    echo "ID: {$kelas->id}, Nama: {$kelas->nama}, Wali Guru ID: {$kelas->wali_guru_id}\n";
}

echo "\n=== SEMUA SISWA ===\n";
$all_siswas = Siswa::with('kelas')->get();
foreach ($all_siswas as $s) {
    echo "ID: {$s->id}, Nama: {$s->nama_lengkap}, NIS: {$s->nis}, Kelas ID: {$s->kelas_id}, Status: {$s->status}\n";
}
