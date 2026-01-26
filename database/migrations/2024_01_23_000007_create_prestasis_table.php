<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('guru_input_id')->constrained('users')->onDelete('restrict');
            $table->string('nama_prestasi');
            $table->integer('poin');
            $table->date('tanggal');
            $table->enum('tingkat', ['kelas', 'sekolah', 'regional', 'nasional'])->default('sekolah');
            $table->string('bukti_file')->nullable();
            $table->enum('status', ['aktif', 'dibatalkan'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['siswa_id']);
            $table->index(['guru_input_id']);
            $table->index(['tanggal']);
            $table->index(['tingkat']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};
