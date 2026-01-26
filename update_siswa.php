<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'aleya@gmail.com')->first();

if ($user) {
    $user->update(['password' => Hash::make('123456')]);
    echo "✓ Password updated for " . $user->email . "\n";
} else {
    $user = User::create([
        'name' => 'Aleya',
        'email' => 'aleya@gmail.com',
        'password' => Hash::make('123456'),
        'role' => 'siswa',
        'email_verified_at' => now()
    ]);
    
    // Create associated siswa record
    Siswa::create([
        'user_id' => $user->id,
        'nis' => 'ALEYA001',
        'nama_lengkap' => 'Aleya',
        'status' => 'aktif'
    ]);
    
    echo "✓ User created: " . $user->email . "\n";
    echo "✓ Student record created\n";
}

echo "Login credentials:\n";
echo "Email: aleya@gmail.com\n";
echo "Password: 123456\n";
