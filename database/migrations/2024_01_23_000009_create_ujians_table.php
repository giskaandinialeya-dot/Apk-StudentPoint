<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('guru_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('kelas_id')->constrained()->onDelete('restrict');
            $table->string('mata_pelajaran');
            $table->enum('tipe', ['online', 'offline'])->default('online');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->integer('durasi_menit')->default(60);
            $table->integer('kkm')->default(70); // Kriteria Ketuntasan Minimum
            $table->integer('jumlah_soal')->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['draft', 'berlangsung', 'selesai'])->default('draft');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['guru_id']);
            $table->index(['kelas_id']);
            $table->index(['status']);
            $table->index(['tanggal_mulai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
