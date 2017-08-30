<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;
use Entrust;
use Request;
use App\Models\User\Permission;

class CheckPermission
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
        $user = Auth::check() ? Auth::user() : '';

        view()->share('sidebarUser', $user);

        $routeName = Route::currentRouteName();
        $permission_info = Permission::where(['name' => $routeName])->first();

        //如果查不到路由名对应的权限直接放行
        if (empty($permission_info)) {
            return $next($request);
        }

        //超级管理员直接放行
        if (!$user->hasRole('Super_Admin')){
            //检查是否有权限
            if (!Entrust::can(Entrust::can($routeName))) {
                //ajax请求直接返回json
                if(Request::ajax()){
                    return response()->json(['status' => 500, 'message' => '权限不足，请联系管理员']);
                }
                //返回session('error');到原页面
                return back()->withInput()->withError('no_permissions');
            }
            //根据路由名称查询权限
            return $next($request);
        }

        return $next($request);
    }
}
