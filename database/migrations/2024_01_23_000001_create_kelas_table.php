<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tingkat'); // X, XI, XII
            $table->foreignId('wali_guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('tahun_ajaran');
            $table->tinyInteger('semester')->default(1);
            $table->year('tahun_kelulusan')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['tahun_ajaran', 'semester']);
            $table->index(['status']);
            $table->unique(['nama', 'tahun_ajaran', 'semester', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
