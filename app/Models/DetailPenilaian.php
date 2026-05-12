<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenilaian extends Model
{
    protected $fillable = [
        'penilaian_id',
        'karyawan_id',
        'kriteria_id',
        'nilai',
    ];

    /**
     * Relasi ke penilaian
     */
    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class);
    }

    /**
     * Relasi ke karyawan
     */
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    /**
     * Relasi ke kriteria
     */
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}