<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

// 飲食店一覧ページ
Route::get('/', [ShopController::class, 'index']);
