<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'guru_input_id',
        'jenis_pelanggaran_id',
        'tanggal',
        'jam',
        'deskripsi',
        'bukti_file',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guruInput()
    {
        return $this->belongsTo(User::class, 'guru_input_id');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPerlanggaran::class);
    }

    // Scopes
    public function scopeRecent($query)
    {
        return $query->orderBy('tanggal', 'desc')->orderBy('jam', 'desc');
    }

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

    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_input_id', $guruId);
    }

    // Accessors
    public function getPoinAttribute()
    {
        return $this->jenisPelanggaran?->poin ?? 0;
    }

    public function getNamaJenisAttribute()
    {
        return $this->jenisPelanggaran?->nama;
    }

    // Events
    protected static function booted()
    {
        static::created(function ($pelanggaran) {
            // Trigger check untuk surat peringatan otomatis
            \App\Services\SuratPeringatanService::checkAndCreateSuratPeringatan($pelanggaran->siswa);
        });
    }
}
