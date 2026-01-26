<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== GURU TABLE SCHEMA ===\n";
$columns = DB::select("SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='gurus' AND TABLE_SCHEMA=DATABASE()");
foreach ($columns as $col) {
    echo "- {$col->COLUMN_NAME}: {$col->COLUMN_TYPE} (nullable: {$col->IS_NULLABLE})\n";
}

echo "\n=== KELAS TABLE SCHEMA ===\n";
$columns = DB::select("SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='kelas' AND TABLE_SCHEMA=DATABASE()");
foreach ($columns as $col) {
    echo "- {$col->COLUMN_NAME}: {$col->COLUMN_TYPE} (nullable: {$col->IS_NULLABLE})\n";
}

echo "\n=== GURU DATA ===\n";
$guru = DB::table('gurus')->where('id', 1)->first();
echo "Guru ID 1:\n";
echo "  kelas_wali_id: {$guru->kelas_wali_id}\n";

echo "\n=== KELAS DATA ===\n";
$kelas = DB::table('kelas')->where('id', 2)->first();
echo "Kelas ID 2:\n";
echo "  nama: {$kelas->nama}\n";
echo "  wali_guru_id: {$kelas->wali_guru_id}\n";
