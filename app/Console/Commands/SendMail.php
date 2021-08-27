<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Reservation;
use App\Models\User;
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
        // 1)当日の予約情報を持つユーザーレコードを予約レコードと共に取得
        $today = date("Y-m-d");

        $users = User::whereHas('reservations' , function ($query) use ($today) {
            $query->where('date', $today);
        })->with(['reservations' => function ($query) use ($today) {
            $query->with('shop')->where('date', $today)->orderby('time', 'asc');
        }])->get();

        // 2)foreachで各ユーザーごとに$dataを設定し、メールを送信する
        foreach ($users as $user) {
            $data = [
                        'user' => $user,
                        'reservations' => $user->reservations,
                    ];

            Mail::send('emails.reminder', $data, function ($message) use($user) {
                $message->to($user->email, $user->name . '様')->subject('本日の予約があります');
            });
        }
    }
}