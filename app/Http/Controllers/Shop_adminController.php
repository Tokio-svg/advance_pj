<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop_admin;

class Shop_adminController extends Controller
{
    // 管理画面トップページ(ユーザー管理画面)
    public function index(Request $request)
    {
        return view('shop.shop_admin');
    }
}
