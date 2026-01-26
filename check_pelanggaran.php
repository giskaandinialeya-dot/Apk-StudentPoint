<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Pelanggaran;
use Carbon\Carbon;

echo "=== CHECK PELANGGARAN ===\n";
$all = Pelanggaran::all();
echo "Total semua pelanggaran: {$all->count()}\n";

$today = Pelanggaran::whereDate('tanggal', today())->get();
echo "Pelanggaran hari ini: {$today->count()}\n";

foreach ($today as $p) {
    echo "\n- ID: {$p->id}\n";
    echo "  Siswa ID: {$p->siswa_id}\n";
    echo "  Siswa: {$p->siswa->nama_lengkap}\n";
    echo "  Jenis: {$p->jenisPelanggaran->nama}\n";
    echo "  Tanggal: {$p->tanggal}\n";
    echo "  Deskripsi: {$p->deskripsi}\n";
}

echo "\n=== RECENT 5 PELANGGARAN ===\n";
$recent = Pelanggaran::with('siswa', 'jenisPelanggaran')
    ->orderBy('tanggal', 'desc')
    ->limit(5)
    ->get();

foreach ($recent as $p) {
    echo "- {$p->siswa->nama_lengkap}: {$p->jenisPelanggaran->nama} ({$p->tanggal})\n";
}
