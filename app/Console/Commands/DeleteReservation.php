<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;

class DeleteReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:reservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '予約日時を過ぎた予約情報を削除';

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
    public function handle()
    {
        $today = date("Y-m-d");

        Reservation::where('date', '<' , $today)->delete();
    }
}
