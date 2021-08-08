<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class ShopController extends Controller
{
    // 飲食店一覧、検索結果表示ページ
    public function index(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'area_id' => $request->input('area_id'),
            'genre_id' => $request->input('genre_id'),
            'shop_name' => $request->input('shop_name'),
        ];

        // 各項目検索
        $query = Shop::query();

        // 地域名
        if (!empty($inputs['area_id'])) {
            $query->where('area_id', $inputs['area_id']);
        }

        // ジャンル名
        if (!empty($inputs['genre_id'])) {
            $query->where('genre_id', $inputs['genre_id']);
        }

        // 店舗名
        if (!empty($inputs['shop_name'])) {
            $query->where('name', 'LIKE', "%{$inputs['shop_name']}%");
        }

        // レコード取得
        $shops = $query->get();

        // 検索フォーム項目用レコード取得
        $areas = Area::has('shops')->get();
        $genres = Genre::has('shops')->get();

        // ユーザー情報取得
        $user = Auth::user();

        return view('index', [
            'shops' => $shops,
            'inputs' => $inputs,
            'areas' => $areas,
            'genres' => $genres,
            'user' => $user,
        ]);
    }

    // 飲食店詳細ページ
    public function detail(Request $request, $shop_id)
    {
        $shop = Shop::find($shop_id);
        // $shop = Shop::with('area')->with('genre')->find($shop_id);
        return view('detail', [
            'shop' => $shop,
        ]);
    }

    // 予約完了ページ
    public function done(Request $request)
    {
        return view('done');
    }
}
