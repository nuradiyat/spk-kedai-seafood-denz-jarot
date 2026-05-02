<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenilaian extends Model
{
    //
    protected $primaryKey = 'id_riwayat';
    protected $fillable = ['id_hasil', 'periode', 'tanggal', 'keterangan'];

    public function hasil()
    {
        return $this->belongsTo(HasilSaw::class, 'id_hasil');
    }
}
