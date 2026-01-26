<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratPeringatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_peringatan';

    protected $fillable = [
        'siswa_id',
        'guru_tanda_tangan_id',
        'level',
        'total_poin',
        'tanggal_terbit',
        'alasan',
        'file_pdf',
        'status',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    protected $dates = ['deleted_at'];

    const LEVEL_SP1 = 1;
    const LEVEL_SP2 = 2;
    const LEVEL_SP3 = 3;
    const LEVEL_SP4 = 4;

    const LEVELS = [
        1 => 'Surat Peringatan 1',
        2 => 'Surat Peringatan 2',
        3 => 'Surat Peringatan 3',
        4 => 'Surat Peringatan 4 (Dikeluarkan)',
    ];

    // Default poin threshold untuk tiap level
    const POIN_THRESHOLD = [
        1 => 10,
        2 => 20,
        3 => 30,
        4 => 40,
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guruTandaTangan()
    {
        return $this->belongsTo(User::class, 'guru_tanda_tangan_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    // Accessors
    public function getLevelLabelAttribute()
    {
        return self::LEVELS[$this->level] ?? 'Unknown';
    }

    public function getIsAkhirAttribute()
    {
        return $this->level === self::LEVEL_SP4;
    }
}
