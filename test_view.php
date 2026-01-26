<?php

$siswa = \App\Models\Siswa::find(4);

$data = [
    'siswa' => $siswa,
    'totalPelanggaranHari' => 0,
    'totalPrestasiHari' => 0,
    'statusHariIni' => null,
    'rekapBulanIni' => ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alfa' => 0],
    'recentPelanggarans' => collect(),
    'recentPrestasis' => collect(),
];

try {
    $view = view('siswa.dashboard', $data);
    echo "✅ View rendered successfully\n";
    echo "✅ No errors detected\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}
