<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('siswa_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('tipe', [
                'poin_kritis',
                'surat_peringatan',
                'panggilan_ortu',
                'nilai_input',
                'absensi_update'
            ])->default('poin_kritis');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_read')->default(false);
            $table->dateTime('read_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['is_read']);
            $table->index(['tipe']);
            $table->index(['siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
