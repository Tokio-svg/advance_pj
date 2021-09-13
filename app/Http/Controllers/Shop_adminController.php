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
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
            'time_start' => $request->input('time_start'),
            'time_end' => $request->input('time_end'),
            'number_start' => $request->input('number_start'),
            'number_end' => $request->input('number_end'),
            'create_start' => $request->input('create_start'),
            'create_end' => $request->input('create_end'),
        ];

        // 各項目検索
        $query = Reservation::query();

        // ユーザーネーム
        if (!empty($inputs['name'])) {
            $query->whereHas('user', function($query) use($inputs) {
                $query->where('name', 'LIKE', "%{$inputs['name']}%");
            });
        }

        // メールアドレス
        if (!empty($inputs['email'])) {
            $query->whereHas('user', function($query) use($inputs) {
                $query->where('email', 'LIKE', "%{$inputs['email']}%");
            });
        }

        // 予約日
        if (!empty($inputs['date_start'])) {
            $query->where('date', '>=', $inputs['date_start']);
        }

        if (!empty($inputs['date_end'])) {
            $query->where('date', '<=', $inputs['date_end']);
        }

        // 予約時間
        if (!empty($inputs['time_start'])) {
            $query->where('time', '>=', $inputs['time_start']);
        }

        if (!empty($inputs['time_end'])) {
            $query->where('time', '<=', $inputs['time_end']);
        }

        // 人数
        if (!empty($inputs['number_start'])) {
            $query->where('number', '>=', $inputs['number_start']);
        }

        if (!empty($inputs['number_end'])) {
            $query->where('number', '<=', $inputs['number_end']);
        }

        // 登録日
        if (!empty($inputs['create_start'])) {
            $query->where('created_at', '>=', $inputs['create_start']);
        }

        if (!empty($inputs['create_end'])) {
            $query->where('created_at', '<=', $inputs['create_end']);
        }

        // 予約情報取得
        $shop_id = Auth::guard('shop')->user()->id;
        $reservations = $query->with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_reservation', [
            'items' => $reservations,
            'inputs' => $inputs,
        ]);
    }

    // お気に入り情報管理画面
    public function favorite(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
        ];

        // 各項目検索
        $query = Favorite::query();

        // ユーザーネーム
        if (!empty($inputs['name'])) {
            $query->whereHas('user', function($query) use($inputs) {
                $query->where('name', 'LIKE', "%{$inputs['name']}%");
            });
        }

        // メールアドレス
        if (!empty($inputs['email'])) {
            $query->whereHas('user', function($query) use($inputs) {
                $query->where('email', 'LIKE', "%{$inputs['email']}%");
            });
        }

        // 登録日
        if (!empty($inputs['date_start'])) {
            $query->where('created_at', '>=', $inputs['date_start']);
        }

        if (!empty($inputs['date_end'])) {
            $query->where('created_at', '<=', $inputs['date_end']);
        }

        // お気に入り情報取得
        $shop_id = Auth::guard('shop')->user()->id;
        $favorites = $query->with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_favorite', [
            'items' => $favorites,
            'inputs' => $inputs,
        ]);
    }

    // 評価情報管理画面
    public function evaluation(Request $request)
    {
        // 入力情報を格納
        $inputs = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'grade_start' => $request->input('grade_start'),
            'grade_end' => $request->input('grade_end'),
            'comment' => $request->input('comment'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
        ];

        // 各項目検索
        $query = Evaluation::query();

        // ユーザーネーム
        if (!empty($inputs['name'])) {
            $query->whereHas('user', function($query) use($inputs) {
                $query->where('name', 'LIKE', "%{$inputs['name']}%");
            });
        }

        // メールアドレス
        if (!empty($inputs['email'])) {
            $query->whereHas('user', function($query) use($inputs) {
                $query->where('email', 'LIKE', "%{$inputs['email']}%");
            });
        }

        // 評価
        if (!empty($inputs['grade_start'])) {
            $query->where('grade', '>=', $inputs['grade_start']);
        }

        if (!empty($inputs['grade_end'])) {
            $query->where('grade', '<=', $inputs['grade_end']);
        }

        // コメント
        if (!empty($inputs['comment'])) {
            $query->where('comment', 'LIKE', "%{$inputs['comment']}%");
        }

        // 登録日
        if (!empty($inputs['date_start'])) {
            $query->where('created_at', '>=', $inputs['date_start']);
        }

        if (!empty($inputs['date_end'])) {
            $query->where('created_at', '<=', $inputs['date_end']);
        }

        // 評価情報取得
        $shop_id = Auth::guard('shop')->user()->id;
        $evaluations = $query->with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_evaluation', [
            'items' => $evaluations,
            'inputs' => $inputs,
        ]);
    }

}
