<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    //
    protected $primaryKey = 'id_karyawan';
    protected $fillable = ['nama_karyawan', 'jabatan', 'tanggal_masuk', 'status'];

    // Relasi dengan DetailPenilaian
    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_karyawan');
    }

    // Relasi dengan HasilSaw
    public function hasilSaw()
    {
        return $this->hasMany(HasilSaw::class, 'id_karyawan');
    }
}
