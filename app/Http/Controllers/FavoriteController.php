<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
// use Log;

class FavoriteController extends Controller
{
    // お気に入りレコード挿入
    public function create(Request $request)
    {
        $favorite = new Favorite;
        $favorite->fill([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id
        ]);
        $favorite->save();

        // 遷移元のurlを取得
        $url = $request->input('url');

        // 遷移元のスクロール位置を取得
        $scroll = ['position' => $request->input('position')];

        return redirect($url)->withInput($scroll);
    }

    // お気に入りレコード削除
    public function delete(Request $request)
    {
        Favorite::where('user_id', $request->user_id)->where('shop_id', $request->shop_id)->delete();

        // 遷移元のurlを取得
        $url = $request->input('url');

        // 遷移元のスクロール位置を取得
        $scroll = ['position' => $request->input('position')];

        return redirect($url)->withInput($scroll);
    }
}
