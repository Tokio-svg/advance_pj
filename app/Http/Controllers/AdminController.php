<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

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
            'inputs' => $inputs,
        ]);
    }

    // 管理画面トップページ(店舗管理画面)
    public function shop(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
            'area_id' => $request->input('area_id'),
            'genre_id' => $request->input('genre_id'),
        ];

        // 各項目検索
        $query = Shop::query();

        // 飲食店名
        if (!empty($inputs['name'])) {
            $query->where('name', 'LIKE', "%{$inputs['name']}%");
        }

        // 地域名
        if (!empty($inputs['area_id'])) {
            $query->where('area_id', $inputs['area_id']);
        }

        // ジャンル名
        if (!empty($inputs['genre_id'])) {
            $query->where('genre_id', $inputs['genre_id']);
        }

        // Shopレコード取得
        $shops = $query->with(['area','genre'])->paginate(10);

        // 検索フォーム項目用レコード取得
        $areas = Area::has('shops')->get();
        $genres = Genre::has('shops')->get();

        return view('admin.admin_shop', [
            'items' => $shops,
            'areas' => $areas,
            'genres' => $genres,
            'inputs' => $inputs,
        ]);
    }

}
