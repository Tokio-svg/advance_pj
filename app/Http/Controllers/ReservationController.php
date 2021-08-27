<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    // 予約レコード挿入
    public function create(ReservationRequest $request)
    {
        $reservation = new Reservation;
        $reservation->fill([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'reminder' => 1,
        ]);
        $reservation->save();

        return redirect('/done');
    }

    // 予約レコード削除
    public function delete(Request $request)
    {
        Reservation::where('id', $request->reservation_id)->delete();

        $url = $request->input('url');

        return redirect($url);
    }
}
