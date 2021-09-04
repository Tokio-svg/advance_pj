<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    // 評価情報格納用にフィールドを設ける
    protected $appends = ['grade'];

    // リレーション設定
    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function genre()
    {
        return $this->belongsTo('App\Models\Genre');
    }

    public function schedule()
    {
        return $this->hasOne('App\Models\Schedule');
    }
}
