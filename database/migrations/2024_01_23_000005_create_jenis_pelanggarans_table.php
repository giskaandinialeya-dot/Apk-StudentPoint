<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('poin');
            $table->enum('kategori', ['ringan', 'sedang', 'berat']);
            $table->text('keterangan')->nullable();
            $table->tinyInteger('auto_sp_level')->nullable(); // Level SP otomatis
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['kategori', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggarans');
    }
};
