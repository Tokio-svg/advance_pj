<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;


// 飲食店一覧ページ
Route::get('/', [ShopController::class, 'index']);
// 飲食店詳細ページ
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);
// マイページ
Route::get('/mypage', [ShopController::class, 'mypage'])->middleware(['auth']);
// お気に入り登録、削除
Route::post('/favorite', [FavoriteController::class, 'create'])->middleware(['auth']);
Route::post('/favorite/delete', [FavoriteController::class, 'delete'])->middleware(['auth']);
// 予約登録、削除、完了ページ
Route::post('/reserve', [ReservationController::class, 'create'])->middleware(['auth']);
Route::post('/reserve/delete', [ReservationController::class, 'delete'])->middleware(['auth']);

// テスト用ルーティング（後で消すこと）
Route::get('/done', [ShopController::class, 'done']);
Route::get('/thanks', [ShopController::class, 'thanks']);

require __DIR__ . '/auth.php';
