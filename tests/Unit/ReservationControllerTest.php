<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Shop;

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

        // switch_reminder(リマインダー設定変更処理)
        $response = $this->post('/reserve/reminder');
        $response->assertRedirect('/login');

        // change(予約情報変更ページ表示)
        $response = $this->get('/reserve/1');
        $response->assertRedirect('/login');

        // update(リマインダー設定変更処理)
        $response = $this->post('/reserve/1');
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

        $shop = Shop::first();  // 登録対象をidが最も若いshopレコードとする
        $shop_id = $shop->id;
        $url = '/'; // 遷移元のURLを'/'とする
        $date = '2121-01-01'; // 日付を2121-01-01とする
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

        $response->assertStatus(200);    // 正常にアクセスできることを確認

        $this->assertDatabaseHas('reservations', [ // 想定されるレコードが存在することを確認
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
            'reminder' => 1,
        ]);

        // switch_reminder(リマインダー設定変更処理)
        $reservation = Reservation::first();    // 上記で挿入したレコードを取得
        $response = $this->post('/reserve/reminder', [
            'reservation_id' => $reservation->id,
            'url'=> $url,
        ]);
        $reservation = Reservation::first();    // 上記で挿入したレコードを再度取得
        $this->assertEquals(0,$reservation->reminder);  // reminderの値が0に変更されていることを確認
        $response->assertRedirect($url);    // $urlにリダイレクトされていることを確認

        // change(予約情報変更ページ表示)
        $reservation = Reservation::first();    // 上記で挿入したレコードを取得
        $response = $this->get('/reserve/' . $reservation->id);
        $response->assertStatus(200);    // 正常にアクセスできることを確認

        $response = $this->get('/reserve/-1');  // 存在しないidを指定してアクセス
        $response->assertStatus(404);    // 404エラーが帰ることを確認

        // update(予約情報変更処理)
        $reservation = Reservation::first();    // 上記で挿入したレコードを取得
        $response = $this->post('/reserve/' . $reservation->id, [
            'date' => '2021-12-31',
            'time' => '20:00',
            'number' => 10,
            'url' => $url,
        ]);
        $this->assertDatabaseHas('reservations', [ // 変更後のレコードが存在することを確認
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'date' => '2021-12-31',
            'time' => '20:00',
            'number' => 10,
        ]);

        $response = $this->post('/reserve/-1', [  // 存在しないidを指定してアクセス
            'date' => '2021-12-31',
            'time' => '20:00',
            'number' => 10,
            'url' => $url,
        ]);

        $response->assertStatus(404);    // 404エラーが帰ることを確認

        // delete(予約取り消し処理)
        $this->assertCount(1, Reservation::all());  // レコード数が1であることを確認
        // IDだけが異なるダミーデータを挿入
        Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
            'reminder' => 1
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
