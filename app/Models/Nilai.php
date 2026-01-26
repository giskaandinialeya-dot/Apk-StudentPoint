<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nilai extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'ujian_id',
        'guru_id',
        'skor',
        'jawaban_file',
        'nilai_akhir',
        'status',
        'tanggal_input',
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    const STATUS_DRAFT = 'draft';
    const STATUS_SUDAH_DINILAI = 'sudah_dinilai';
    const STATUS_SELESAI = 'selesai';

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Scopes
    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    public function scopeByUjian($query, $ujianId)
    {
        return $query->where('ujian_id', $ujianId);
    }

    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getNilaiHurufAttribute()
    {
        $nilai = $this->nilai_akhir;

        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }

    public function getStatusLulusAttribute()
    {
        return $this->nilai_akhir >= ($this->ujian->kkm ?? 70);
    }
}
