<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasilSaw extends Model
{
    protected $fillable = [
        'penilaian_id',
        'karyawan_id',
        'nilai_akhir',
        'ranking',
        'status_bonus',
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
     * Relasi riwayat
     */
    public function riwayatPenilaians(): HasMany
    {
        return $this->hasMany(RiwayatPenilaian::class);
    }
}
