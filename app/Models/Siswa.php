<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'kelas_id',
        'tahun_ajaran',
        'semester',
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

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function absentis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function rapors()
    {
        return $this->hasMany(Rapor::class);
    }

    public function suratPeringatan()
    {
        return $this->hasMany(SuratPeringatan::class);
    }

    public function orangTua()
    {
        return $this->hasMany(OrangTua::class);
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'siswa_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')->whereNull('deleted_at');
    }

    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    // Accessors
    public function getTotalPoinPelanggaranAttribute()
    {
        return $this->pelanggarans()
            ->with('jenisPelanggaran')
            ->get()
            ->sum(function ($p) {
                return $p->jenisPelanggaran->poin ?? 0;
            });
    }

    public function getTotalPoinPrestasiAttribute()
    {
        return $this->prestasis()->sum('poin');
    }

    public function getSaldoPoinAttribute()
    {
        return $this->total_poin_prestasi - $this->total_poin_pelanggaran;
    }

    public function getStatusKehadiranHariIniAttribute()
    {
        return $this->absentis()
            ->whereDate('tanggal', today())
            ->first()?->status ?? null;
    }
}
