<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $fillable = [
        'nama_karyawan',
        'jabatan',
        'tanggal_masuk',
        'status',
    ];

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

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_karyawan', 'like', "%{$keyword}%")
                ->orWhere('jabatan', 'like', "%{$keyword}%")
                ->orWhere('status', 'like', "%{$keyword}%");
        });
    }
}
