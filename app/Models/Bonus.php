<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    //
    protected $fillable = [
        'penilaian_id',
        'total_bonus',
        'status_bonus',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
