<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Shop_admin;
use App\Models\Shop;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{

    // adminガードのゲストとしてのアクセスを許可するミドルウェアを登録
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:admin')->except(['create_shop_admin', 'store_shop_admin']);
        $this->middleware('guest:shop');
    }

    // ----------------------------------------------------------------------
    // ユーザー登録処理群
    // ----------------------------------------------------------------------
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => ['required', Rules\Password::defaults()],
        // ]);

        // email:uniqueバリデーション
        $request->email_unique(null);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return view('thanks');
    }


    // ----------------------------------------------------------------------
    // 管理者登録処理群
    // ----------------------------------------------------------------------
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create_admin()
    {
        return view('admin.admin_register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store_admin(RegisterRequest $request)
    {

        // 管理者認証キーバリデーション
        $request->admin_key_check();

        // email:uniqueバリデーション
        $request->admin_email_unique(null);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($admin));

        // Auth::login($user);

        return redirect(route('admin.login'));
    }

    // ----------------------------------------------------------------------
    // 飲食店管理者登録処理群
    // ----------------------------------------------------------------------
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create_shop_admin()
    {
        // 全Shopレコードを取得
        $shops = Shop::get(['id','name']);
        return view('shop.shop_admin_register', [
            'shops' => $shops,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store_shop_admin(RegisterRequest $request)
    {

        // email:uniqueバリデーション
        $request->shop_email_unique(null);

        Log::debug($request->shop_id);

        $shop_admin = Shop_admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'shop_id' => $request->shop_id,
        ]);

        event(new Registered($shop_admin));

        // Auth::login($user);

        return redirect(route('shop.login'));
    }

}
