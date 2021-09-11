<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Symfony\Component\Console\Input\Input;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'password' => 'required|min:8|max:191',
        ];
    }

    // エラーメッセージ
    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.string' => 'メールアドレスの形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは191文字以下で入力してください',
        ];
    }

    /**
     * 引数で渡されたID以外のUserのemailと入力値を比較し、
     * 同一のものがある場合はバリデーションエラーを返す
     * （引数にnullが渡された場合はIDに条件を設けずに比較する）
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function email_unique($user_id)
    {
        if ($user_id) {
            $count = User::whereNotIn('id', [$user_id])->where('email', $this->input('email'))->count();
        } else {
            $count = User::where('email', $this->input('email'))->count();
        }
        if ($count) {
            throw ValidationException::withMessages([
                'email' => 'そのメールアドレスは既に使用されています',
            ]);
        }

    }

    /**
     * 管理者用
     *
     * 引数で渡されたID以外のUserのemailと入力値を比較し、
     * 同一のものがある場合はバリデーションエラーを返す
     * （引数にnullが渡された場合はIDに条件を設けずに比較する）
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function admin_email_unique($admin_id)
    {
        if ($admin_id) {
            $count = Admin::whereNotIn('id', [$admin_id])->where('email', $this->input('email'))->count();
        } else {
            $count = Admin::where('email', $this->input('email'))->count();
        }
        if ($count) {
            throw ValidationException::withMessages([
                'email' => 'そのメールアドレスは既に使用されています',
            ]);
        }

    }

}
