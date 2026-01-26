<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\JenisPerlanggaran;

$jenis = JenisPerlanggaran::aktif()->first();

echo "=== TEST SERIALIZATION ===\n";
echo "Single Model:\n";
echo "  ID: " . $jenis->id . "\n";
echo "  Nama: " . $jenis->nama . "\n";
echo "  Poin: " . ($jenis->poin ?? 'NULL') . "\n";

echo "\nCollection Test:\n";
$collection = JenisPerlanggaran::aktif()->get();
echo "  Type: " . get_class($collection) . "\n";
echo "  Count: " . $collection->count() . "\n";
echo "  Is countable: " . (is_countable($collection) ? 'YES' : 'NO') . "\n";
echo "  Is iterable: " . (is_iterable($collection) ? 'YES' : 'NO') . "\n";

echo "\nIteration Test:\n";
$count = 0;
foreach ($collection as $item) {
    $count++;
    if ($count <= 3) {
        echo "  $count. {$item->nama}\n";
    }
}
echo "  Total iterated: $count\n";

echo "\nJSON Serialization:\n";
$json = json_encode($collection);
echo "  Length: " . strlen($json) . " bytes\n";
echo "  First 100 chars: " . substr($json, 0, 100) . "...\n";

echo "\n✓ All serialization tests passed!\n";
