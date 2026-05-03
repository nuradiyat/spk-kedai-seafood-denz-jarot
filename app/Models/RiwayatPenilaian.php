<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPenilaian extends Model
{
    // digunakan untuk menentukan kolom mana saja yang bisa diisi secara massal
    protected $fillable = [
        'hasil_saw_id',
        'periode',
        'tanggal',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function hasil(): BelongsTo
    {
        return $this->belongsTo(HasilSaw::class);
    }
}