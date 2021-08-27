<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '当日の予約情報を持つユーザーにメールを送信';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    // メールを送信
    public function handle()
    {
        // 1) 当日の予約レコードを取得
        $today = date("Y-m-d");
        $items = Reservation::with('user')->with('shop')->where('date',$today)->get();

        // 2)foreachで各レコードごとに$dataを設定、メールを送信する
        foreach ($items as $item) {
            $data = [
                'item' => $item,
            ];

            Mail::send('emails.reminder', $data, function ($message) use($item) {
                $message->to($item->user->email, $item->user->name . '様')->subject('本日の予約があります');
            });
        }
    }
}
