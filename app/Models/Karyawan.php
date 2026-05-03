<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    // disini kita tentukan kolom mana saja yang bisa diisi secara massal
    protected $fillable = [
        'nama_karyawan',
        'jabatan',
        'tanggal_masuk',
        'status'
    ];

    public function detailPenilaian(): HasMany
    {
        return $this->hasMany(DetailPenilaian::class);
    }

    public function hasilSaw(): HasMany
    {
        return $this->hasMany(HasilSaw::class);
    }
}