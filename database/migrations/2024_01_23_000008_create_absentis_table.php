<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absentis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('guru_input_id')->constrained('users')->onDelete('restrict');
            $table->date('tanggal');
            $table->tinyInteger('jam_ke')->nullable(); // Jam pelajaran ke- (1-8)
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alfa'])->default('hadir');
            $table->string('keterangan')->nullable();
            $table->timestamp('sinkronisasi_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['siswa_id']);
            $table->index(['guru_input_id']);
            $table->index(['tanggal']);
            $table->index(['status']);
            $table->unique(['siswa_id', 'tanggal', 'jam_ke', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absentis');
    }
};
