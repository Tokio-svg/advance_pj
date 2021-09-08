<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;

class AdminController extends Controller
{
    // 管理画面トップページ
    public function index(Request $request)
    {
        // ユーザーレコード取得
        $users = User::all();

        return view('admin', [
            'users' => $users,
        ]);
    }
}
