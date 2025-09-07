<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class CentralUser extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql';   // central connection
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'kode_user',
        'password',
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
