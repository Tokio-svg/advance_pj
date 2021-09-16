<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'image_url' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'area_id' => 'required|numeric',
            'genre_id' => 'required|numeric',
            'overview' => 'required|string|max:191',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'public' => 'required|numeric',
        ];
    }

    // エラーメッセージ
    public function messages()
    {
        return [
            'image_url.required' => '画像URLを入力してください',
            'name.required' => '名前を入力してください',
            'area_id.required' => '地域を選択してください',
            'genre_id.required' => 'ジャンルを選択してください',
            'overview.required' => '概要を入力してください',
            'opening_time.required' => '開店時間を選択してください',
            'closing_time.required' => '閉店時間を選択してください',
            'public.required' => '公開情報を選択してください',
        ];
    }

}
