<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Shop_admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'shop';

    protected $fillable = [
        'name', 'email', 'password','shop_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
