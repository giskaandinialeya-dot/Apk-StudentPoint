<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ujian_id',
        'urutan',
        'pertanyaan',
        'tipe',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'jawaban_benar',
        'bobot',
        'status',
    ];

    protected $dates = ['deleted_at'];

    const TIPE_PILIHAN_GANDA = 'pilihan_ganda';
    const TIPE_ESSAY = 'essay';
    const TIPE_TRUE_FALSE = 'true_false';

    const TIPES = [
        'pilihan_ganda' => 'Pilihan Ganda',
        'essay' => 'Essay',
        'true_false' => 'Benar/Salah',
    ];

    // Relationships
    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    // Scopes
    public function scopeByUjian($query, $ujianId)
    {
        return $query->where('ujian_id', $ujianId)->orderBy('urutan');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Methods
    public function isPilihanGanda()
    {
        return $this->tipe === self::TIPE_PILIHAN_GANDA;
    }

    public function isEssay()
    {
        return $this->tipe === self::TIPE_ESSAY;
    }

    public function isTrueFalse()
    {
        return $this->tipe === self::TIPE_TRUE_FALSE;
    }
}
