<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // adminガードでログインしていたら次の処理に進む
        if (auth()->guard('admin')->check()) {
            return $next($request);
        }

        // ログインしていなかったらリダイレクト
        return redirect(route('admin.login'));
    }
}
