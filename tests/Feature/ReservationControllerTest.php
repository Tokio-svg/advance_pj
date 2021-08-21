<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;
    // リフレッシュ時のシーディングを有効にする
    private $seed = true;

    // 非ログイン状態でアクセス
    public function test_guest()
    {
        // create(予約登録処理)
        $response = $this->post('/reserve');
        $response->assertRedirect('/login');

        // delete(予約取り消し処理)
        $response = $this->post('/reserve/delete');
        $response->assertRedirect('/login');
    }

    // ログイン状態でアクセス
    public function test_login()
    {
        $user = User::create([  // ユーザーを作成
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);
        $this->actingAs($user); // ログイン

        $shop_id = 1;   // 登録対象のshopのidを1とする
        $url = '/'; // 遷移元のURLを'/'とする
        $date = '2021-01-01'; // 日付を2021-01-01とする
        $time = '12:00';    // 時間を12:00とする
        $number = 1;    // 人数を1とする

        // create(予約登録処理)
        $response = $this->post('/reserve', [
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);

        $response->assertRedirect('/done');    // /doneにリダイレクトされることを確認
        $this->assertDatabaseHas('reservations', [ // 想定されるレコードが存在することを確認
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);

        // delete(予約取り消し処理)
        $this->assertCount(1, Reservation::all());  // レコード数が1であることを確認
        $reservation = Reservation::first();    // 上記で挿入したレコードを取得
        // IDだけが異なるダミーデータを挿入
        Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);

        $response = $this->post('/reserve/delete', [
            'reservation_id' => $reservation->id,
            'url' => $url,
        ]);

        $response->assertRedirect($url);    // $urlにリダイレクトされることを確認
        $this->assertDatabaseMissing('reservations', [ // 想定されるレコードが存在しないことを確認
            'id' => $reservation->id,
        ]);
        $this->assertCount(1, Reservation::all());  // レコード数が1であることを確認(ダミーデータが残っていることを確認)
    }
}
