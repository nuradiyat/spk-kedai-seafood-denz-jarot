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
     * data yang bisa diisi untuk kriteria dan bisa diisi untuk penilaian
     * serta data yang bisa diisi untuk detail penilaian
     * apa kita bisa menghapus detail penilaian jika kriteria dihapus? atau kita bisa menghapus penilaian jika kriteria dihapus?
     * kita bisa menghapus penilaian jika kriteria dihapus, karena penilaian memiliki relasi dengan kriteria, jadi jika kriteria 
     * dihapus maka penilaian yang terkait juga akan dihapus. Namun, kita tidak bisa menghapus detail penilaian jika kriteria dihapus, karena detail penilaian memiliki relasi dengan penilaian, jadi jika penilaian dihapus maka detail penilaian yang terkait juga akan dihapus.
     */
    public function detailPenilaians(): HasMany
    {
        return $this->hasMany(DetailPenilaian::class);
    }
}
