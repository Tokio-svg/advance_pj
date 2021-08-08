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
        // Log::debug($request);
        $favorite = new Favorite;
        $favorite->fill([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id
        ]);
        $favorite->save();

        $url = $request->input('url');

        return redirect($url);
    }

    // お気に入りレコード削除
    public function delete(Request $request)
    {
        Favorite::where('user_id', $request->user_id)->where('shop_id', $request->shop_id)->delete();

        $url = $request->input('url');

        return redirect($url);
    }
}
