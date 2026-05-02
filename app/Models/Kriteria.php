<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    //
    protected $primaryKey = 'id_kriteria';
    protected $fillable = ['kode', 'nama_kriteria', 'bobot', 'jenis'];

    // Relasi dengan DetailPenilaian
    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_kriteria');
    }
}
