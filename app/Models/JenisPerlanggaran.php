<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisPerlanggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_pelanggarans';

    protected $fillable = [
        'nama',
        'poin',
        'kategori',
        'keterangan',
        'auto_sp_level',
        'status',
    ];

    protected $dates = ['deleted_at'];

    const KATEGORI_RINGAN = 'ringan';
    const KATEGORI_SEDANG = 'sedang';
    const KATEGORI_BERAT = 'berat';

    const KATEGORI = [
        'ringan' => 'Ringan (1-3 poin)',
        'sedang' => 'Sedang (4-10 poin)',
        'berat' => 'Berat (11+ poin)',
    ];

    // Relationships
    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')->whereNull('deleted_at');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeRingan($query)
    {
        return $query->where('kategori', self::KATEGORI_RINGAN);
    }

    public function scopeSedang($query)
    {
        return $query->where('kategori', self::KATEGORI_SEDANG);
    }

    public function scopeBerat($query)
    {
        return $query->where('kategori', self::KATEGORI_BERAT);
    }
}
