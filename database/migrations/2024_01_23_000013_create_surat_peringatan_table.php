<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_peringatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('guru_tanda_tangan_id')->nullable()->constrained('users')->onDelete('set null');
            $table->tinyInteger('level'); // 1, 2, 3, 4
            $table->integer('total_poin');
            $table->date('tanggal_terbit');
            $table->text('alasan')->nullable();
            $table->string('file_pdf')->nullable();
            $table->enum('status', ['aktif', 'dibatalkan'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['siswa_id']);
            $table->index(['level']);
            $table->index(['status']);
            $table->index(['tanggal_terbit']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_peringatan');
    }
};
