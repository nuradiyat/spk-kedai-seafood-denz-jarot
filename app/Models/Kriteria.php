<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $fillable = [
        'kode',
        'nama_kriteria',
        'bobot',
        'jenis',
    ];

    /**
     * Relasi detail penilaian
     */
    public function detailPenilaians(): HasMany
    {
        return $this->hasMany(DetailPenilaian::class);
    }
}
