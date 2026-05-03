<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // kita gunakan trait Notifiable untuk mengirim notifikasi
    use Notifiable;
   
    // disini kita tentukan kolom mana saja yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }
}