<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Evaluation;

class Shop_adminController extends Controller
{
    // 管理画面トップページ(飲食店情報管理画面)
    public function index(Request $request)
    {
        // 店舗情報取得
        $shop_id = Auth::guard('shop')->user()->id;
        $shop = Shop::with(['area','genre'])->find($shop_id);

        return view('shop.shop_admin', [
            'shop' => $shop,
        ]);
    }

    // 予約情報管理画面
    public function reservation(Request $request)
    {
        // 予約情報取得
        $shop_id = Auth::guard('shop')->user()->id;
        $reservations = Reservation::with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_reservation', [
            'items' => $reservations,
        ]);
    }

    // お気に入り情報管理画面
    public function favorite(Request $request)
    {
        // お気に入り情報取得
        $shop_id = Auth::guard('shop')->user()->id;
        $favorites = Favorite::with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_favorite', [
            'items' => $favorites,
        ]);
    }

    // 評価情報管理画面
    public function evaluation(Request $request)
    {
        // 評価情報取得
        $shop_id = Auth::guard('shop')->user()->id;
        $evaluations = Evaluation::with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_evaluation', [
            'items' => $evaluations,
        ]);
    }

}
