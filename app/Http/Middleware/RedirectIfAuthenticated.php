<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // 管理者としてログイン中に他の認証画面にアクセスした場合はユーザー管理画面にリダイレクト
                if ($guard === 'admin') {
                    return redirect(route('admin.user'));
                }

                // 飲食店管理者としてログイン中に他の認証画面にアクセスした場合は飲食店管理画面トップにリダイレクト
                if ($guard === 'shop') {
                    return redirect(route('shop.top'));
                }

                return redirect('/');
            }
        }

        return $next($request);
    }
}
