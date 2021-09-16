<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Evaluation;
use App\Models\Genre;
use App\Models\Schedule;
use App\Http\Requests\ShopRequest;

class Shop_adminController extends Controller
{
    // 管理画面トップページ(飲食店情報管理画面)
    public function index(Request $request)
    {
        // 店舗情報取得
        $shop_id = Auth::guard('shop')->user()->shop_id;
        $shop = Shop::with(['area','genre'])->find($shop_id);
        $schedule = Schedule::where('shop_id', $shop_id)->first();

        return view('shop.shop_admin', [
            'shop' => $shop,
            'schedule' => $schedule,
        ]);
    }

    // 登録情報変更画面表示
    public function change(Request $request)
    {
        // 店舗情報取得
        $shop_id = Auth::guard('shop')->user()->shop_id;
        $shop = Shop::with(['area','genre'])->find($shop_id);
        $schedule = Schedule::where('shop_id', $shop_id)->first();

        // 地域、ジャンル選択項目取得
        $areas = Area::get(['id','name']);
        $genres = Genre::get(['id','name']);

        return view('shop.shop_admin_update', [
            'shop' => $shop,
            'schedule' => $schedule,
            'areas' => $areas,
            'genres' => $genres,
        ]);
    }

    // 登録情報変更処理
    public function update(ShopRequest $request)
    {
        // 店舗情報取得
        $shop_id = Auth::guard('shop')->user()->shop_id;
        $shop = Shop::find($shop_id);

        // 営業日時情報取得
        $schedule = Schedule::where('shop_id', $shop_id)->first();

        if (!$shop || !$schedule) {
            abort(404);
        }

        // レコード更新
        $shop->fill([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'overview' => $request->overview,
            'image_url' => $request->image_url,
            'public' => $request->public,
        ])->save();

        $day_of_week = [$this->convert_day($request->sun), $this->convert_day($request->mon), $this->convert_day($request->tue), $this->convert_day($request->wed), $this->convert_day($request->thu), $this->convert_day($request->fri), $this->convert_day($request->sat)];

        $schedule->fill([
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'day_of_week' => $day_of_week,
        ])->save();

        return redirect(route('shop.top'));
    }

    public function convert_day($value) {
        if (!$value) {
            return 0;
        }
        return 1;
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
        $shop_id = Auth::guard('shop')->user()->shop_id;
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
        $shop_id = Auth::guard('shop')->user()->shop_id;
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
        $shop_id = Auth::guard('shop')->user()->shop_id;
        $evaluations = $query->with('user')->where('shop_id', $shop_id)->paginate(10);

        return view('shop.shop_admin_evaluation', [
            'items' => $evaluations,
            'inputs' => $inputs,
        ]);
    }

}
