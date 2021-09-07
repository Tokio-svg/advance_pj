<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EvaluationController;


// 飲食店一覧ページ
Route::get('/', [ShopController::class, 'index']);
// 飲食店詳細ページ
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

// authミドルウェア適用グループ
Route::group(['middleware' => 'auth'], function() {
  // マイページ
  Route::get('/mypage', [ShopController::class, 'mypage']);
  // お気に入り登録、削除
  Route::post('/favorite', [FavoriteController::class, 'create']);
  Route::post('/favorite/delete', [FavoriteController::class, 'delete']);
  // 予約登録、削除、変更
  Route::post('/reserve', [ReservationController::class, 'create']);
  Route::post('/reserve/delete', [ReservationController::class, 'delete']);
  Route::post('/reserve/reminder', [ReservationController::class, 'switch_reminder']);
  Route::get('/reserve/{reservation_id}', [ReservationController::class, 'change']);
  Route::post('/reserve/{reservation_id}', [ReservationController::class, 'update']);
  // 評価投稿
  Route::get('/evaluation/{shop_id}', [EvaluationController::class, 'evaluation']);
  Route::post('/evaluation', [EvaluationController::class, 'create']);
});

// テスト用ルーティング（後で消すこと）
Route::get('/done', [ShopController::class, 'done']);
Route::get('/thanks', [ShopController::class, 'thanks']);

require __DIR__ . '/auth.php';
