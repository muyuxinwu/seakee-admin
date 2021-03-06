<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	//为后台加载JWT eloquent配置文件，用于后台账号的登录和token刷新
	    config(['jwt.user' => '\App\Models\Users\AdminUser']);
	    config(['auth.providers.users.model' => \App\Models\Users\AdminUser::class]);

        return $next($request);
    }
}
