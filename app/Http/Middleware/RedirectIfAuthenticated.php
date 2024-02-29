<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
            // return redirect()->route('loginView')->withErrors('タイムアウトしました。もう一度ログインしてください。');
            //タイムアウトするとlogin画面へ遷移するように変更
            // 確認方法⇒セッションの時間変更？env?session.php?
        }

        return $next($request);
    }
}
