<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ujian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'guru_id',
        'kelas_id',
        'mata_pelajaran',
        'tipe',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_menit',
        'kkm',
        'jumlah_soal',
        'status',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    const TIPE_ONLINE = 'online';
    const TIPE_OFFLINE = 'offline';

    const TIPES = [
        'online' => 'Online/CBT',
        'offline' => 'Offline/Tulis',
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_BERLANGSUNG = 'berlangsung';
    const STATUS_SELESAI = 'selesai';

    const STATUSES = [
        'draft' => 'Draft',
        'berlangsung' => 'Sedang Berlangsung',
        'selesai' => 'Selesai',
    ];

    // Relationships
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', '!=', self::STATUS_DRAFT)->whereNull('deleted_at');
    }

    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }

    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getIsBerlangsungAttribute()
    {
        return $this->status === self::STATUS_BERLANGSUNG;
    }

    public function getIsSelesaiAttribute()
    {
        return $this->status === self::STATUS_SELESAI;
    }
}
