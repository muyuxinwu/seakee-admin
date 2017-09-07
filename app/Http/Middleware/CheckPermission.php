<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Route;
use Request;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use Cache;

class CheckPermission
{
    /**
     * @var RoleInterface
     */
    private $role;

    /**
     * @var PermissionInterface
     */
    private $permission;

    /**
     * AdminSidebarComposer constructor.
     *
     * @param RoleInterface $role
     * @param PermissionInterface $permission
     */
    public function __construct(RoleInterface $role, PermissionInterface $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //从session中获取登录用户信息
        $user = session('user');
        //没有用户信息跳转登录页面
        if (empty($user)) {
            return Redirect::intended('/login');
        }

        $allPermission = $this->getAllPermission();
        $currentUserRole = $this->getCurrentUserRole($user->id);
        $currentUserPermission = $this->getCurrentUserPermission($user->id, $allPermission);

        view()->share('sidebarUser', $user);

        $routeName = Route::currentRouteName();

        //如果查不到路由名对应的权限直接放行
        if (!in_array($routeName, $allPermission)) {
            return $next($request);
        }

        //超级管理员直接放行
        if (!in_array(1, $currentUserRole)) {
            //检查是否有权限
            if (!in_array($routeName, $currentUserPermission)) {
                //ajax请求直接返回json
                if (Request::ajax()) {
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


    /**
     * 获取当前用户权限
     *
     * @param $userId
     * @param $allPermission
     * @return mixed
     */
    private function getCurrentUserPermission($userId, $allPermission)
    {
        $currentUserPermission = Cache::tags(['user', $userId])->get('currentUserPermission');
        if (empty($currentUserPermission)) {

            $currentUserRole = $this->getCurrentUserRole($userId);
            $currentUserPermission = $this->permission->currentUserPermission($currentUserRole, $allPermission);

            Cache::tags(['user', $userId])->put('currentUserPermission', $currentUserPermission, 10);
        }

        return $currentUserPermission;
    }

    /**
     * 获取所有权限
     *
     * @return mixed
     */
    private function getAllPermission()
    {
        $allPermission = Cache::get('allPermission');
        if (empty($allPermission)) {

            $allPermission = $this->permission->allPermissionName();
            Cache::put('allPermission', $allPermission, 10);
        }

        return $allPermission;
    }

    /**
     * 获取当前用户角色
     *
     * @param $userId
     * @return mixed
     */
    private function getCurrentUserRole($userId)
    {
        $currentUserRole = Cache::tags(['user', $userId])->get('currentUserRole');
        if (empty($currentUserRole)) {

            $currentUserRole = $this->role->currentUserRole($userId);;
            Cache::tags(['user', $userId])->put('currentUserRole', $currentUserRole, 10);
        }

        return $currentUserRole;
    }
}
