<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilSaw extends Model
{
    // di sini kita akan menyimpan hasil perhitungan SAW untuk setiap karyawan pada setiap penilaian
    protected $fillable = [
        'penilaian_id',
        'karyawan_id',
        'nilai_akhir',
        'ranking',
        'status_bonus'
    ];

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class);
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }
}