<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Opsional jika nama tabel 'users'
    // protected $primaryKey = 'id'; // Opsional jika primary key 'id'

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role', // <<< PASTIKAN INI ADA
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role'); // <<< PASTIKAN INI ADA
    }
}