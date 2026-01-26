<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifikasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifikasis';

    protected $fillable = [
        'user_id',
        'siswa_id',
        'tipe',
        'judul',
        'deskripsi',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    const TIPE_POIN_KRITIS = 'poin_kritis';
    const TIPE_SP = 'surat_peringatan';
    const TIPE_PANGGILAN_ORTU = 'panggilan_ortu';
    const TIPE_NILAI_INPUT = 'nilai_input';
    const TIPE_ABSENSI_UPDATE = 'absensi_update';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function markAsRead()
    {
        $this->is_read = true;
        $this->read_at = now();
        $this->save();

        return $this;
    }

    public function markAsUnread()
    {
        $this->is_read = false;
        $this->read_at = null;
        $this->save();

        return $this;
    }
}
