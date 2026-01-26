<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\JenisPerlanggaran;

echo "=== CEK JENIS PELANGGARAN ===\n";
$allData = JenisPerlanggaran::all();
echo "Total semua jenis: {$allData->count()}\n";
foreach ($allData as $d) {
    echo "ID: {$d->id}, Nama: {$d->nama}, Status: {$d->status}\n";
}

echo "\n=== CEK JENIS PELANGGARAN AKTIF ===\n";
$aktifData = JenisPerlanggaran::aktif()->get();
echo "Total jenis aktif: {$aktifData->count()}\n";
foreach ($aktifData as $d) {
    echo "ID: {$d->id}, Nama: {$d->nama}, Status: {$d->status}\n";
}
