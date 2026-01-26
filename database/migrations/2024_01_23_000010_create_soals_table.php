<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained()->onDelete('cascade');
            $table->integer('urutan');
            $table->longText('pertanyaan');
            $table->enum('tipe', ['pilihan_ganda', 'essay', 'true_false'])->default('pilihan_ganda');
            $table->text('opsi_a')->nullable();
            $table->text('opsi_b')->nullable();
            $table->text('opsi_c')->nullable();
            $table->text('opsi_d')->nullable();
            $table->text('opsi_e')->nullable();
            $table->string('jawaban_benar')->nullable(); // A, B, C, D, E, atau jawaban essay
            $table->integer('bobot')->default(1);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['ujian_id']);
            $table->index(['urutan']);
            $table->unique(['ujian_id', 'urutan', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
