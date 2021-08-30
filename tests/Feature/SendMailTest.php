<?php

namespace Tests\Feature;

use App\Mail\ReminderMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Reservation;

class SendMailTest extends TestCase
{
    use RefreshDatabase;
    // リフレッシュ時のシーディングを有効にする
    private $seed = true;

    public function test_command_send_mail()
    {
        // ユーザーを作成
        $user = User::create([
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);

        // 予約レコードを作成
        $date = date("Y-m-d");
        Reservation::create([
            'user_id' => $user->id,
            'shop_id' => 1,
            'date' => $date,
            'time' => '10:00',
            'number' => 1,
            'reminder' => 1
        ]);

        // 実際にはメールを送らないように設定
        Mail::fake();

        // メールが送られていないことを確認
        Mail::assertNothingSent();

        // メールを送信
        $this->artisan('send:mail')
             ->assertExitCode(0);

        // メッセージが指定したユーザーに届いたことをアサート
        Mail::assertSent(ReminderMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        // メールが1回送信されたことをアサート
        Mail::assertSent(ReminderMail::class, 1);
    }
}
