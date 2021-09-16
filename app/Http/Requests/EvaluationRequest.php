<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
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
            'nickname' => 'string|max:191',
            'grade' => 'required|between:1,5',
            'comment' => 'required|string|max:120',
        ];
    }

    // エラーメッセージ
    public function messages()
    {
        return [
            'grade.required' => '評価を選択してください',
            'grade.between' => '正しい値を選択してください',
            'comment.required' => 'コメントを入力してください',
            'comment.max' => 'コメントは120文字以内で入力してください',
        ];
    }
}
