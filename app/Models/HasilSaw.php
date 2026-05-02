<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSaw extends Model
{
    //
    protected $table = 'hasil_saw';
    protected $primaryKey = 'id_hasil';
    protected $fillable = ['id_penilaian', 'id_karyawan', 'nilai_akhir', 'ranking', 'status_bonus'];

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

    // Relasi dengan RiwayatPenilaian
    public function riwayat()
    {
        return $this->hasMany(RiwayatPenilaian::class, 'id_hasil');
    }
}
