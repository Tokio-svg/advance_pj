<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    // protected $guarded = array('id');
    protected $fillable = [
        'id',
        'name',
    ];

    // リレーション設定
    public function shops()
    {
        return $this->hasMany('App\Models\Shop');
    }
}