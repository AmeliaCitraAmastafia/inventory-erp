<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'google_id',
        'name',
        'email',
        'avatar',
        'google_token',
        'google_refresh_token',
    ];

    protected $hidden = [
        'remember_token',
        'google_token',
        'google_refresh_token',
    ];
}
