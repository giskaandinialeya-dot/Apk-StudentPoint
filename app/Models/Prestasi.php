<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prestasis';

    protected $fillable = [
        'siswa_id',
        'guru_input_id',
        'nama_prestasi',
        'poin',
        'tanggal',
        'tingkat',
        'bukti_file',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected $dates = ['deleted_at'];

    const TINGKAT_KELAS = 'kelas';
    const TINGKAT_SEKOLAH = 'sekolah';
    const TINGKAT_REGIONAL = 'regional';
    const TINGKAT_NASIONAL = 'nasional';

    const TINGKATS = [
        'kelas' => 'Tingkat Kelas',
        'sekolah' => 'Tingkat Sekolah',
        'regional' => 'Tingkat Regional',
        'nasional' => 'Tingkat Nasional',
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
    public function scopeRecent($query)
    {
        return $query->orderBy('tanggal', 'desc');
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

    public function scopeByTingkat($query, $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }
}
