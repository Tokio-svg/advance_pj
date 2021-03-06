<?php

namespace App\Http\Requests;

use App\Models\Admin;
use App\Models\Shop;
use App\Models\Shop_admin;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
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
     * 引数で渡されたID以外のAdminのemailと入力値を比較し、
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

    /**
     * 管理者用
     *
     * 管理者認証キーチェック
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function admin_key_check()
    {
        if (hash('md5', $this->input('key')) != config('app.admin_key')) {
            throw ValidationException::withMessages([
                'key' => '管理者認証キーが違います',
            ]);
        }
    }

    /**
     * 飲食店管理者用
     *
     * 引数で渡されたID以外のShop_adminのemailと入力値を比較し、
     * 同一のものがある場合はバリデーションエラーを返す
     * （引数にnullが渡された場合はIDに条件を設けずに比較する）
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function shop_email_unique($shop_id)
    {
        if ($shop_id) {
            $count = Shop_admin::whereNotIn('id', [$shop_id])->where('email', $this->input('email'))->count();
        } else {
            $count = Shop_admin::where('email', $this->input('email'))->count();
        }
        if ($count) {
            throw ValidationException::withMessages([
                'email' => 'そのメールアドレスは既に使用されています',
            ]);
        }
    }

    /**
     * 飲食店管理者用
     *
     * $this->input('shop_id')の値が入力されているか(required)、
     * Shopsテーブルに存在するidかどうかをチェックし、
     * それぞれのバリデーションメッセージを返す
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function shop_id_check()
    {
        $input = $this->input('shop_id');

        // requiredチェック
        if (!$input) {
            throw ValidationException::withMessages([
                'shop_id' => '飲食店を選択してください',
            ]);
        }

        // Shop存在チェック
        $count = Shop::where('id', $input)->count();
        if (!$count) {
            throw ValidationException::withMessages([
                'shop_id' => 'その飲食店は存在しません',
            ]);
        }

    }

}
