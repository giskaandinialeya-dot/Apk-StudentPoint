<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('restrict');
            $table->string('mata_pelajaran');
            $table->string('tahun_ajaran');
            $table->tinyInteger('semester');
            $table->integer('nilai_pengetahuan')->nullable();
            $table->integer('nilai_keterampilan')->nullable();
            $table->integer('nilai_sikap')->nullable();
            $table->integer('nilai_akhir')->nullable();
            $table->string('nilai_huruf')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('keterangan')->nullable();
            $table->dateTime('tanggal_input')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['siswa_id']);
            $table->index(['guru_id']);
            $table->index(['tahun_ajaran', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapors');
    }
};
