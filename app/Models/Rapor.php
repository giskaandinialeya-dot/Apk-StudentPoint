<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rapor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'mata_pelajaran',
        'tahun_ajaran',
        'semester',
        'nilai_pengetahuan',
        'nilai_keterampilan',
        'nilai_sikap',
        'nilai_akhir',
        'nilai_huruf',
        'deskripsi',
        'keterangan',
        'tanggal_input',
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
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

    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }

    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Methods
    public function calculateNilaiAkhir()
    {
        $this->nilai_akhir = round(
            ($this->nilai_pengetahuan * 0.5) +
            ($this->nilai_keterampilan * 0.3) +
            ($this->nilai_sikap * 0.2)
        );

        return $this->nilai_akhir;
    }

    public function getNilaiHurufFromAkhir()
    {
        $nilai = $this->nilai_akhir;

        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }
}
