<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'absentis';

    protected $fillable = [
        'siswa_id',
        'guru_input_id',
        'tanggal',
        'jam_ke',
        'status',
        'keterangan',
        'sinkronisasi_at',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'sinkronisasi_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    const STATUS_HADIR = 'hadir';
    const STATUS_SAKIT = 'sakit';
    const STATUS_IZIN = 'izin';
    const STATUS_ALFA = 'alfa';

    const STATUSES = [
        'hadir' => 'Hadir',
        'sakit' => 'Sakit',
        'izin' => 'Izin',
        'alfa' => 'Alfa',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guruInput()
    {
        return $this->belongsTo(User::class, 'guru_input_id');
    }

    // Scopes
    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    public function scopeByBulan($query, $bulan, $tahun)
    {
        return $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
    }

    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeHadir($query)
    {
        return $query->where('status', self::STATUS_HADIR);
    }

    public function scopeSakit($query)
    {
        return $query->where('status', self::STATUS_SAKIT);
    }

    public function scopeIzin($query)
    {
        return $query->where('status', self::STATUS_IZIN);
    }

    public function scopeAlfa($query)
    {
        return $query->where('status', self::STATUS_ALFA);
    }

    // Methods
    public function isHadir()
    {
        return $this->status === self::STATUS_HADIR;
    }

    public function isSakit()
    {
        return $this->status === self::STATUS_SAKIT;
    }

    public function isIzin()
    {
        return $this->status === self::STATUS_IZIN;
    }

    public function isAlfa()
    {
        return $this->status === self::STATUS_ALFA;
    }
}
