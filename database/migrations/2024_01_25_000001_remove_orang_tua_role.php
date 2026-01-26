<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Delete any orang_tua users from database first
        DB::table('users')->where('role', 'orang_tua')->delete();

        // Drop orang_tuas table if it exists
        Schema::dropIfExists('orang_tuas');

        // Update users table enum to remove orang_tua role
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('admin', 'guru', 'siswa') NOT NULL");
    }

    public function down(): void
    {
        // Restore the original enum
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('admin', 'guru', 'siswa', 'orang_tua') NOT NULL");
    }
};
