<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'spesialisasi',
        'kelas_wali_id',
        'foto',
        'status',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasWali()
    {
        return $this->hasOne(Kelas::class, 'wali_guru_id', 'user_id');
    }

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class, 'guru_input_id', 'user_id');
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class, 'guru_input_id', 'user_id');
    }

    public function absentis()
    {
        return $this->hasMany(Absensi::class, 'guru_input_id', 'user_id');
    }

    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'guru_id', 'user_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'guru_id', 'user_id');
    }

    public function rapors()
    {
        return $this->hasMany(Rapor::class, 'guru_id', 'user_id');
    }

    public function suratPeringatan()
    {
        return $this->hasMany(SuratPeringatan::class, 'guru_tanda_tangan_id', 'user_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')->whereNull('deleted_at');
    }

    public function scopeBySpesialisasi($query, $spesialisasi)
    {
        return $query->where('spesialisasi', $spesialisasi);
    }

    public function scopeWaliKelas($query)
    {
        return $query->whereNotNull('kelas_wali_id');
    }

    // Methods
    public function isWaliKelas()
    {
        return $this->kelas_wali_id !== null;
    }

    public function getSiswaWaliAttribute()
    {
        return $this->kelasWali?->siswas()->aktif()->get();
    }
}
