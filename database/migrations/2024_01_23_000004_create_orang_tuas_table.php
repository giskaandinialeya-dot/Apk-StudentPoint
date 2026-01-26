<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orang_tuas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->enum('hubungan', ['ayah', 'ibu', 'wali'])->default('ayah');
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('email_pribadi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['siswa_id']);
            $table->index(['hubungan']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orang_tuas');
    }
};
