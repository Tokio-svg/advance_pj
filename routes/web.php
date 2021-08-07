<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

// 飲食店一覧ページ
Route::get('/', [ShopController::class, 'index']);
// 飲食店詳細ページ
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

// テスト用ルーティング（後で消すこと）
Route::post('/done', [ShopController::class, 'done']);
