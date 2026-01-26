<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Reset password untuk admin, guru
$users = [
    ['email' => 'admin@epoin.com', 'password' => 'password'],
    ['email' => 'guru@epoin.com', 'password' => 'password'],
];

foreach ($users as $userData) {
    $user = User::where('email', $userData['email'])->first();
    if ($user) {
        $user->update(['password' => Hash::make($userData['password'])]);
        echo "✓ Password diubah untuk {$user->email} menjadi {$userData['password']}\n";
    }
}

// Konfirmasi Aleya tetap 123456
$aleya = User::where('email', 'aleya@gmail.com')->first();
if ($aleya) {
    echo "\n✓ Akun Aleya tetap dengan password: 123456\n";
}

echo "\n=== PASSWORD BARU ===\n";
echo "Admin: admin@epoin.com / password\n";
echo "Guru: guru@epoin.com / password\n";
echo "Siswa (Aleya): Aleya@gmail.com / 123456\n";
