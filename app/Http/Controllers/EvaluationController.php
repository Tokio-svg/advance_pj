<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Evaluation;
use App\Http\Requests\EvaluationRequest;

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

        // 既に評価を投稿している場合は評価レコードを取得する
        $evaluation = Evaluation::where('user_id', $user->id)->first();

        return view('evaluation', [
            'user' => $user,
            'shop' => $shop,
            'evaluation' => $evaluation,
        ]);
    }

    // 評価レコード作成もしくは更新
    public function create(EvaluationRequest $request)
    {
        if ($request->evaluation_id) {
            // idが指定されている場合は更新処理
            $evaluation = Evaluation::find($request->evaluation_id);
            $evaluation->fill([
                'grade' => $request->grade,
                'comment' => $request->comment,
            ])->save();
        } else {
            // idが指定されていない場合は作成処理
            Evaluation::create([
                'user_id' => $request->user_id,
                'shop_id' => $request->shop_id,
                'grade' => $request->grade,
                'comment' => $request->comment,
            ]);
        }

        // 遷移元のURLを取得
        $url = $request->url;

        return view('evaluate_done', [
            'url' => $url,
        ]);
    }
}
