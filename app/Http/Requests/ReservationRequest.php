<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\Schedule;
use DateTime;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date|after_or_equal:tomorrow',
            'time' => 'required|date_format:H:i',
            'number' => 'required|numeric',
        ];
    }

    // エラーメッセージ
    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'date.date' => '日付を選択してください',
            'date.after_or_equal' => '日付を選択してください',
            'time.required' => '時間を選択してください',
            'time.date_format' => '時間を選択してください',
            'number.required' => '人数を選択してください',
            'number.numeric' => '人数を選択してください',
        ];
    }

    /**
     * 引数に渡されたshop_idから営業日情報を取得し、
     * バリデーションを行う
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check_close($shop_id)
    {
        // shop_idカラムに$shop_idを持つScheduleレコードを取得
        $schedule = Schedule::where('shop_id', $shop_id)->first();

        // date入力フォームの値から曜日番号を取得
        $datetime = new DateTime($this->input('date'));
        $index = $datetime->format('w');

        $open = $schedule->day_of_week[$index];

        // $openが0ならエラーメッセージと共にバリデーションエラーを返す
        if ($open === 0) {
            throw ValidationException::withMessages([
                'date' => '選択した日付は定休日です',
            ]);
        }
    }

}
