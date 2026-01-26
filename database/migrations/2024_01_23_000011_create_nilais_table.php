<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('ujian_id')->constrained()->onDelete('restrict');
            $table->foreignId('guru_id')->constrained('users')->onDelete('restrict');
            $table->integer('skor')->nullable();
            $table->string('jawaban_file')->nullable();
            $table->integer('nilai_akhir')->nullable();
            $table->enum('status', ['draft', 'sudah_dinilai', 'selesai'])->default('draft');
            $table->dateTime('tanggal_input')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['siswa_id']);
            $table->index(['ujian_id']);
            $table->index(['guru_id']);
            $table->index(['status']);
            $table->unique(['siswa_id', 'ujian_id', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
