<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    //
    protected $fillable = [
        'penilaian_id',
        'user_id',
        'total_bonus',
        'keterangan',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
