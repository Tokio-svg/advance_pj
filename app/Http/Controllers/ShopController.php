<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Favorite;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
// use Log;

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
        // ログイン状態では関連するお気に入り情報を取得する
        if (Auth::check()) {
            $shops = $query->with(['favorites' => function ($query) {
                $query->where('user_id', Auth::user()->id);
            }])->get();
        } else {
            $shops = $query->get();
        }

        // 評価情報取得
        $grades = array();
        foreach ($shops as $shop) {
            // 5段階評価の内訳を取得
            for ($i = 1; $i < 6; $i++) {
                $grades[$i] = Evaluation::where('shop_id', $shop->id)->where('grade', $i)->count();
            }
            // [0]に総数を格納
            $grades[0] = $grades[1] + $grades[2] + $grades[3] + $grades[4] + $grades[5];
            // [6]に平均値を格納(評価が無い場合は0を格納する)
            if ($grades[0] != 0) {
                $grades[6] = round(($grades[1] + ($grades[2] * 2) + ($grades[3] * 3) + ($grades[4] * 4) + ($grades[5] * 5)) / $grades[0],2);
            } else {
                $grades[6] = 0;
            }
            // 評価平均情報をモデルに追加
            $shop->grade = $grades[6];
        }

        // 検索フォーム項目用レコード取得
        $areas = Area::has('shops')->get();
        $genres = Genre::has('shops')->get();

        // お気に入り操作時のスクロール位置を取得
        if ($request->old()) {
            $position = $request->old()['position'];
        } else {
            $position = 0;
        }

        return view('index', [
            'shops' => $shops,
            'inputs' => $inputs,
            'areas' => $areas,
            'genres' => $genres,
            'position' => $position,
        ]);
    }

    // 飲食店詳細ページ
    public function detail(Request $request, $shop_id)
    {
        $shop = Shop::with(['area','genre','schedule'])->find($shop_id);

        if (!$shop) {
            abort(404);
        }

        // 最新3件の評価情報を取得
        $comments = Evaluation::with('user')->where('shop_id', $shop_id)->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->take(3)->get();

        $grades = array();
        if ($comments->count()) {
            // 5段階評価の内訳を取得
            for($i=1; $i<6; $i++) {
                $grades[$i] = Evaluation::where('shop_id', $shop_id)->where('grade', $i)->count();
            }
            // [0]に総数を格納
            $grades[0] = $grades[1] + $grades[2] + $grades[3] + $grades[4] + $grades[5];
            // [6]に平均値を格納
            $grades[6] = ($grades[1] + ($grades[2] * 2) + ($grades[3] * 3) + ($grades[4] * 4) + ($grades[5] * 5)) / $grades[0];
        } else {    // 評価レコードが無い場合は配列の要素全てに0を格納する
            for($i=0; $i<7; $i++) {
                $grades[$i] = 0;
            }
        }

        return view('detail', [
            'shop' => $shop,
            'comments' => $comments,
            'grades' => $grades,
        ]);
    }

    // テスト用（後で消すこと）
    // 予約完了ページ
    public function done(Request $request)
    {
        return view('done');
    }
    // サンクスページ
    public function thanks(Request $request)
    {
        return view('thanks');
    }
}
