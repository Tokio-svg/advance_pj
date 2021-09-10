<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;


// 飲食店一覧ページ
Route::get('/', [ShopController::class, 'index']);
// 飲食店詳細ページ
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

// authミドルウェア適用グループ
Route::group(['middleware' => 'auth'], function() {

  // マイページ
  Route::group(['prefix' => 'mypage'], function () {
    Route::get('', [UserController::class, 'mypage']);
    Route::get('update', [UserController::class, 'change']);
    Route::post('update', [UserController::class, 'update']);
    Route::post('delete', [UserController::class, 'delete']);
  });

  // お気に入り登録、削除
  Route::group(['prefix' => 'favorite'], function () {
    Route::post('', [FavoriteController::class, 'create']);
    Route::post('delete', [FavoriteController::class, 'delete']);
  });

  // 予約登録、削除、変更
  Route::group(['prefix' => 'reserve'], function () {
    Route::post('', [ReservationController::class, 'create']);
    Route::post('delete', [ReservationController::class, 'delete']);
    Route::post('reminder', [ReservationController::class, 'switch_reminder']);
    Route::get('{reservation_id}', [ReservationController::class, 'change']);
    Route::post('{reservation_id}', [ReservationController::class, 'update']);
  });

  // 評価投稿
  Route::group(['prefix' => 'evaluation'], function () {
    Route::get('{shop_id}', [EvaluationController::class, 'evaluation']);
    Route::post('', [EvaluationController::class, 'create']);
  });

});

// admin.authミドルウェア適用グループ
Route::group(['middleware' => 'admin.auth'], function() {

  // 管理画面(管理者用)
  Route::group(['prefix' => 'admin'], function () {
    // ユーザー管理
    Route::get('user', [AdminController::class, 'index']);
    Route::post('user/delete', [AdminController::class, 'delete_user']);
    // 店舗管理
    Route::get('shop', [AdminController::class, 'shop']);
    Route::post('shop/delete', [AdminController::class, 'delete_shop']);
  });

});

// テスト用ルーティング（後で消すこと）
Route::get('/done', [ShopController::class, 'done']);
Route::get('/thanks', [ShopController::class, 'thanks']);

require __DIR__ . '/auth.php';
