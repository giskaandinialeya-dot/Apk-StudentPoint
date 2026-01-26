<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\JenisPerlanggaran;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== DIAGNOSTIC JENIS PELANGGARAN ===\n\n";

// 1. Check raw database
echo "1. CEK DATABASE LANGSUNG:\n";
$dbRecords = DB::table('jenis_pelanggarans')
    ->whereNull('deleted_at')
    ->get();
echo "   Total records (not soft deleted): {$dbRecords->count()}\n";

$activeRecords = DB::table('jenis_pelanggarans')
    ->where('status', 'aktif')
    ->whereNull('deleted_at')
    ->get();
echo "   Total records with status='aktif': {$activeRecords->count()}\n";

// 2. Check via Model
echo "\n2. CEK VIA ELOQUENT MODEL:\n";
$allModel = JenisPerlanggaran::all();
echo "   JenisPerlanggaran::all() count: {$allModel->count()}\n";

$aktifModel = JenisPerlanggaran::aktif()->get();
echo "   JenisPerlanggaran::aktif()->get() count: {$aktifModel->count()}\n";

// 3. Check scope
echo "\n3. CEK SCOPE AKTIF:\n";
$modelMock = new JenisPerlanggaran();
echo "   Scope aktif method exists: " . (method_exists($modelMock, 'scopeAktif') ? 'YES' : 'NO') . "\n";

// 4. Show first 5 records
echo "\n4. SAMPEL DATA:\n";
foreach($aktifModel->take(5) as $j) {
    echo "   ID: {$j->id}, Nama: {$j->nama}, Status: {$j->status}\n";
}

echo "\n=== END DIAGNOSTIC ===\n";
