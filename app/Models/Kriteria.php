<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    // disini kita tentukan kolom mana saja yang bisa diisi secara massal
    protected $fillable = [
        'kode',
        'nama_kriteria',
        'bobot',
        'jenis'
    ];

    protected $casts = [
        'bobot' => 'float',
    ];

    public function detailPenilaian(): HasMany
    {
        return $this->hasMany(DetailPenilaian::class);
    }
}