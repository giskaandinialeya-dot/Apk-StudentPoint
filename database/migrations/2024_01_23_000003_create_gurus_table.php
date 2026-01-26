<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('spesialisasi'); // Mata pelajaran
            $table->foreignId('kelas_wali_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'pensiun'])->default('aktif');
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['spesialisasi']);
            $table->index(['kelas_wali_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
