<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;

class AdminController extends Controller
{
    // 管理画面トップページ(ユーザー管理画面)
    public function index(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        // 各項目検索
        $query = User::query();

        // ユーザーネーム
        if (!empty($inputs['name'])) {
            $query->where('name', 'LIKE', "%{$inputs['name']}%");
        }

        // メールアドレス
        if (!empty($inputs['email'])) {
            $query->where('email', 'LIKE', "%{$inputs['email']}%");
        }

        // Userレコード取得
        $users = $query->paginate(10);

        return view('admin.admin', [
            'items' => $users,
        ]);
    }

    // 管理画面トップページ(店舗管理画面)
    public function shop(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
        ];

        // 各項目検索
        $query = Shop::query();

        // ユーザーネーム
        if (!empty($inputs['name'])) {
            $query->where('name', 'LIKE', "%{$inputs['name']}%");
        }

        // Shopレコード取得
        $shops = $query->with(['area','genre'])->paginate(10);

        return view('admin.admin_shop', [
            'items' => $shops,
        ]);
    }

}
