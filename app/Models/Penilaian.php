<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penilaian extends Model
{
    // digunakan untuk menentukan kolom mana saja yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'periode',
        'tanggal_penilaian'
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailPenilaian::class);
    }

    public function hasil(): HasMany
    {
        return $this->hasMany(HasilSaw::class);
    }
}