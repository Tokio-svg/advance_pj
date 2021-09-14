<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Evaluation;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // 管理画面トップページ(ユーザー管理画面)
    public function index(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
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

        // 登録日
        if (!empty($inputs['date_start'])) {
            $query->where('created_at', '>=', $inputs['date_start']);
        }

        if (!empty($inputs['date_end'])) {
            $query->where('created_at', '<=', $inputs['date_end']);
        }

        // Userレコード取得
        $users = $query->paginate(10);

        // test
        $admin = Auth::guard('admin')->user()->name;

        return view('admin.admin', [
            'items' => $users,
            'inputs' => $inputs,
            'admin' => $admin,
        ]);
    }

    // ユーザー削除処理
    public function delete_user(Request $request)
    {
        // 各種パラメータを取得
        $user_id = $request->user_id;
        $url = $request->url;

        // 削除処理
        User::where('id', $user_id)->delete();
        Reservation::where('user_id', $user_id)->delete();
        Favorite::where('user_id', $user_id)->delete();
        Evaluation::where('user_id', $user_id)->delete();

        return redirect($url);
    }

    // 管理画面トップページ(店舗管理画面)
    public function shop(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
            'area_id' => $request->input('area_id'),
            'genre_id' => $request->input('genre_id'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
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

        // 登録日
        if (!empty($inputs['date_start'])) {
            $query->where('created_at', '>=', $inputs['date_start']);
        }

        if (!empty($inputs['date_end'])) {
            $query->where('created_at', '<=', $inputs['date_end']);
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

        // ユーザー削除処理
        public function delete_shop(Request $request)
        {
            // 各種パラメータを取得
            $shop_id = $request->shop_id;
            $url = $request->url;

            // 削除処理
            Shop::where('id', $shop_id)->delete();
            Reservation::where('shop_id', $shop_id)->delete();
            Favorite::where('shop_id', $shop_id)->delete();
            Evaluation::where('shop_id', $shop_id)->delete();
            Schedule::where('shop_id', $shop_id)->delete();

            return redirect($url);
        }

}
