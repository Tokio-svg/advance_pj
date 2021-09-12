<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

class Shop_adminController extends Controller
{
    // 管理画面トップページ(ユーザー管理画面)
    public function index(Request $request)
    {
        // 店舗情報取得
        $shop = Shop::find(Auth::guard('shop')->user()->id);

        return view('shop.shop_admin', [
            'shop' => $shop,
        ]);
    }
}
