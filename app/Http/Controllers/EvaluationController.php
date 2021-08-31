<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    // 評価投稿ページ表示
    public function evaluation(Request $request, $shop_id)
    {
        $user = Auth::user();

        $shop = Shop::with('area')->with('genre')->find($shop_id);

        if (!$shop) {
            abort(404);
        }

        return view('evaluation', [
            'user' => $user,
            'shop' => $shop,
        ]);
    }

    // 評価レコード作成
    public function create(Request $request)
    {
        Evaluation::create([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id,
            'grade' => $request->grade,
            'comment' => $request->comment,
        ]);

        return redirect('/mypage');
    }
}
