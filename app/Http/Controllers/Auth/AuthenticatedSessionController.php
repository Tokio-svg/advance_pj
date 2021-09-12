<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{

    // adminガードのゲストとしてのアクセスを許可するミドルウェアを登録
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
        $this->middleware('guest:admin')->except('destroy_admin');
    }

    // ----------------------------------------------------------------------
    // ユーザーログイン処理群
    // ----------------------------------------------------------------------
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    // ----------------------------------------------------------------------
    // 管理者ログイン処理群
    // ----------------------------------------------------------------------
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create_admin()
    {
        return view('admin.admin_login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_admin(LoginRequest $request)
    {
        $request->admin_authenticate();

        $request->session()->regenerate();

        return redirect(route('admin.user'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_admin(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }

    // ----------------------------------------------------------------------
    // 飲食店管理者ログイン処理群
    // ----------------------------------------------------------------------
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create_shop_admin()
    {
        return view('shop.shop_admin_login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_shop_admin(LoginRequest $request)
    {
        $request->shop_authenticate();

        $request->session()->regenerate();

        return redirect(route('shop.top'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_shop_admin(Request $request)
    {
        Auth::guard('shop')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('shop.login'));
    }

}
