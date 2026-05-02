<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    //
    protected $primaryKey = 'id_penilaian';
    protected $fillable = ['id_user', 'periode', 'tanggal_penilaian'];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi dengan DetailPenilaian
    public function detail()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_penilaian');
    }

    // Relasi dengan HasilSaw
    public function hasil()
    {
        return $this->hasMany(HasilSaw::class, 'id_penilaian');
    }
}
