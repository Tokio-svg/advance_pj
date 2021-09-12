<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;

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
        $reservation = Reservation::with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_reservation', [
            'items' => $reservation,
        ]);
    }

}
