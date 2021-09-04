<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'shop_id' => 1,
            'opening_time' => '10:00',
            'closing_time' => '20:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 0,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 2,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    0,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 3,
            'opening_time' => '09:00',
            'closing_time' => '22:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   0,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 4,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   0,
            'wednesday' => 0,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 5,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 6,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 7,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 8,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 9,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 10,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 11,
            'opening_time' => '10:00',
            'closing_time' => '20:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 0,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 12,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    0,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 13,
            'opening_time' => '09:00',
            'closing_time' => '22:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   0,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 14,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   0,
            'wednesday' => 0,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 15,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 16,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 17,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 18,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 19,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'shop_id' => 20,
            'opening_time' => '10:00',
            'closing_time' => '21:00',
            'sunday' =>    1,
            'monday' =>    1,
            'tuesday' =>   1,
            'wednesday' => 1,
            'thursday' =>  1,
            'friday' =>    1,
            'saturday' =>  1,
        ];
        DB::table('schedules')->insert($param);
    }
}
