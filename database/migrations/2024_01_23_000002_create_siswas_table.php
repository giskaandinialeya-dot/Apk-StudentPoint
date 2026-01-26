<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('nis')->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->string('tahun_ajaran');
            $table->tinyInteger('semester')->default(1);
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'lulus', 'pindah'])->default('aktif');
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['kelas_id', 'status']);
            $table->index(['tahun_ajaran', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
