<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penilaian extends Model
{
    protected $fillable = [
        'user_id',
        'periode',
        'tanggal_penilaian',
        // 'total_bonus',
        'status_perhitungan',
    ];

    /**
     * Relasi ke user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi detail penilaian
     */
    public function detailPenilaians(): HasMany
    {
        return $this->hasMany(DetailPenilaian::class);
    }

    /**
     * Relasi hasil SAW
     */
    public function hasilSaws(): HasMany
    {
        return $this->hasMany(HasilSaw::class);
    }

    // relasi bonus
    public function bonus()
    {
        return $this->hasOne(Bonus::class);
    }

    // relasi riwayat penilaian
    public function riwayat()
    {
        return $this->hasOne(RiwayatPenilaian::class);
    }
}
