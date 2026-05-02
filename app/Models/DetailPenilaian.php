<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    //
    protected $primaryKey = 'id_detail';
    protected $fillable = ['id_penilaian', 'id_karyawan', 'id_kriteria', 'nilai'];

    // Relasi dengan Penilaian
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian');
    }

    // Relasi dengan Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    // Relasi dengan Kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
