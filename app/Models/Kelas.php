<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'tingkat',
        'wali_guru_id',
        'tahun_ajaran',
        'semester',
        'tahun_kelulusan',
        'status',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function waliGuru()
    {
        return $this->belongsTo(User::class, 'wali_guru_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'wali_guru_id', 'user_id');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function ujians()
    {
        return $this->hasMany(Ujian::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')->whereNull('deleted_at');
    }

    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    public function scopeByTingkat($query, $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    // Accessors
    public function getJumlahSiswaAttribute()
    {
        return $this->siswas()->aktif()->count();
    }

    public function getRataPoinPelanggaranAttribute()
    {
        return $this->siswas()
            ->avg(function ($siswa) {
                return $siswa->total_poin_pelanggaran;
            });
    }

    public function getRataPoinPrestasiAttribute()
    {
        return $this->siswas()
            ->avg(function ($siswa) {
                return $siswa->total_poin_prestasi;
            });
    }
}
