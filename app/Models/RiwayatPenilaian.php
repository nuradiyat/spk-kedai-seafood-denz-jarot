<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPenilaian extends Model
{
    protected $fillable = [
        'hasil_saw_id',
        'periode',
        'tanggal',
        'keterangan',
    ];

    /**
     * Relasi ke hasil SAW
     */
    public function hasilSaw(): BelongsTo
    {
        return $this->belongsTo(HasilSaw::class);
    }
}