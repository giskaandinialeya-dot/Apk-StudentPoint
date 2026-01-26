<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\JenisPerlanggaran;

echo "=== CREATE CUSTOM JENIS PELANGGARAN ===\n";

// Create custom violations
$customs = [
    ['nama' => 'Makan di Kelas', 'poin' => 2, 'kategori' => 'ringan'],
    ['nama' => 'Tidak Mengikuti Upacara', 'poin' => 5, 'kategori' => 'sedang'],
    ['nama' => 'Membawa Minuman Beralkohol', 'poin' => 15, 'kategori' => 'berat'],
];

foreach ($customs as $custom) {
    try {
        $existing = JenisPerlanggaran::where('nama', $custom['nama'])->first();
        if (!$existing) {
            $jenis = JenisPerlanggaran::create([
                'nama' => $custom['nama'],
                'poin' => $custom['poin'],
                'kategori' => $custom['kategori'],
                'keterangan' => "Pelanggaran custom: {$custom['nama']}",
                'status' => 'aktif',
            ]);
            echo "✓ Created: {$jenis->nama} ({$jenis->poin} poin)\n";
        } else {
            echo "- Already exists: {$custom['nama']}\n";
        }
    } catch (\Exception $e) {
        echo "✗ Error creating {$custom['nama']}: " . $e->getMessage() . "\n";
    }
}

echo "\n=== ALL JENIS PELANGGARAN ===\n";
$all = JenisPerlanggaran::orderBy('poin', 'asc')->get();
foreach ($all as $j) {
    echo "{$j->id}. {$j->nama} - {$j->poin} poin ({$j->kategori}) - Status: {$j->status}\n";
}
