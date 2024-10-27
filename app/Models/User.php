<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CrudTrait;
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'username', 'password', 'is_blocked',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

