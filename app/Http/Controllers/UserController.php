<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Evaluation;
use App\Models\User;


class UserController extends Controller
{
    // マイページ
    public function mypage(Request $request)
    {
        $user = Auth::user();
        // 予約情報を取得
        $reservations = Reservation::where('user_id', $user->id)->get();
        // お気に入り情報を取得
        $favorites = Favorite::with('shop')->where('user_id', $user->id)->get();

        // 評価情報取得
        $grades = array();
        foreach ($favorites as $favorite) {
            // 5段階評価の内訳を取得
            for ($i = 1; $i < 6; $i++) {
                $grades[$i] = Evaluation::where('shop_id', $favorite->shop->id)->where('grade', $i)->count();
            }
            // [0]に総数を格納
            $grades[0] = $grades[1] + $grades[2] + $grades[3] + $grades[4] + $grades[5];
            // [6]に平均値を格納(評価が無い場合は0を格納する)
            if ($grades[0] != 0) {
                $grades[6] = round(($grades[1] + ($grades[2] * 2) + ($grades[3] * 3) + ($grades[4] * 4) + ($grades[5] * 5)) / $grades[0], 2);
            } else {
                $grades[6] = 0;
            }
            // 評価平均情報をモデルに追加
            $favorite->shop->grade = $grades[6];
        }

        return view('mypage', [
            'user' => $user,
            'reservations' => $reservations,
            'favorites' => $favorites,
        ]);
    }

    // 登録情報変更ページ表示
    public function change(Request $request)
    {
        $user = Auth::user();

        return view('mypage_update', [
            'user' => $user,
        ]);
    }

    // 登録情報変更処理
    public function update(RegisterRequest $request)
    {
        // ログイン中のユーザー情報を取得
        $user = Auth::user();
        // email:uniqueバリデーション
        $request->email_unique($user->id);

        $user_record = User::find($user->id);

        $user_record->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->save();

        // 完了画面に渡すパラメータを設定
        $message = '登録情報を変更しました';
        $url = '/mypage';

        return view('done_mypage', [
            'message' => $message,
            'url' => $url,
        ]);
    }

    // ユーザー削除処理
    public function delete(Request $request)
    {
        $user_id = Auth::user()->id;
        // ログアウト処理
        Auth::guard('user')->logout();
        $request->session()->invalidate();

        // 削除処理
        User::where('id', $user_id)->delete();
        Reservation::where('user_id', $user_id)->delete();
        Favorite::where('user_id', $user_id)->delete();
        Evaluation::where('user_id', $user_id)->delete();

        // 完了画面に渡すパラメータを設定
        $message = 'またのご利用お待ちしております';
        $url = '/';

        return view('done_mypage', [
            'message' => $message,
            'url' => $url,
        ]);
    }
}
