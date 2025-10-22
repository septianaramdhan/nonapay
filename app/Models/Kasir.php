<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Kasir extends Authenticatable
{
    protected $table = 'kasirs';

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
