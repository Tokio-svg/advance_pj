<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Shop_adminController;


// 飲食店一覧ページ
Route::get('/', [ShopController::class, 'index']);
// 飲食店詳細ページ
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

// authミドルウェア適用グループ
Route::group(['middleware' => 'auth'], function() {

  // マイページ
  Route::group(['prefix' => 'mypage', 'as' => 'mypage.'], function () {
    Route::get('', [UserController::class, 'mypage'])->name('top');
    Route::get('update', [UserController::class, 'change'])->name('change');
    Route::post('update', [UserController::class, 'update'])->name('update');
    Route::post('delete', [UserController::class, 'delete'])->name('delete');
  });

  // お気に入り登録、削除
  Route::group(['prefix' => 'favorite', 'as' => 'favorite.'], function () {
    Route::post('', [FavoriteController::class, 'create'])->name('create');
    Route::post('delete', [FavoriteController::class, 'delete'])->name('delete');
  });

  // 予約登録、削除、変更
  Route::group(['prefix' => 'reserve', 'as' => 'reserve.'], function () {
    Route::post('', [ReservationController::class, 'create'])->name('create');
    Route::post('delete', [ReservationController::class, 'delete'])->name('delete');
    Route::post('reminder', [ReservationController::class, 'switch_reminder'])->name('reminder');
    Route::get('{reservation_id}', [ReservationController::class, 'change'])->name('change');
    Route::post('{reservation_id}', [ReservationController::class, 'update'])->name('update');
  });

  // 評価投稿
  Route::group(['prefix' => 'evaluation', 'as' => 'evaluation.'], function () {
    Route::get('{shop_id}', [EvaluationController::class, 'evaluation'])->name('top');
    Route::post('', [EvaluationController::class, 'create'])->name('create');
  });

});

// admin.authミドルウェア適用グループ
Route::group(['middleware' => 'admin.auth'], function() {

  // 管理画面(管理者用)
  Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // ユーザー管理
    Route::get('user', [AdminController::class, 'index'])->name('user');
    Route::post('user/delete', [AdminController::class, 'delete_user'])->name('user.delete');
    // 店舗管理
    Route::get('shop', [AdminController::class, 'shop'])->name('shop');
    Route::post('shop/delete', [AdminController::class, 'delete_shop'])->name('shop.delete');
  });

});

// shop.authミドルウェア適用グループ
Route::group(['middleware' => 'shop.auth'], function() {

  // 管理画面(飲食店管理者用)
  Route::group(['prefix' => 'shop_admin', 'as' => 'shop.'], function () {
    // 飲食店情報管理
    Route::get('', [Shop_adminController::class, 'index'])->name('top');
    // 予約情報管理
    Route::get('reservation', [Shop_adminController::class, 'reservation'])->name('reservation');
  });

});

// テスト用ルーティング（後で消すこと）
Route::get('/done', [ShopController::class, 'done']);
Route::get('/thanks', [ShopController::class, 'thanks']);

require __DIR__ . '/auth.php';
