<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    // 営業日情報をJSONから配列にキャスト
    protected $casts = [
        'day_of_week' => 'array'
    ];
}
