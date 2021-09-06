<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
}
