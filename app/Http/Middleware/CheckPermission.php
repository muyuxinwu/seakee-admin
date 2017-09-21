<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Route;
use Request;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;

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
	 * @param RoleInterface       $role
	 * @param PermissionInterface $permission
	 */
	public function __construct(RoleInterface $role, PermissionInterface $permission)
	{
		$this->role       = $role;
		$this->permission = $permission;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
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

		$currentUserRole = $this->role->currentUserRole($user);

		view()->share('sidebarUser', $user);

		$routeName = Route::currentRouteName();

		//超级管理员直接放行
		if (!in_array('Super_Admin', $currentUserRole)) {

			$currentUserPermission = $this->permission->currentUserPermission($user);
			$allPermission         = $this->permission->allPermissionName();

			//如果查不到路由名对应的权限直接放行
			if (!in_array($routeName, $allPermission)) {
				return $next($request);
			}

			//检查是否有权限
			if (!in_array($routeName, $currentUserPermission)) {
				//ajax请求直接返回json
				if (Request::ajax()) {
					return response()->json([
						'status'  => 500,
						'message' => '权限不足，请联系管理员',
					]);
				}

				//返回session('error');到原页面
				return back()->withInput()->withError('no_permissions');
			}

			return $next($request);
		}

		return $next($request);
	}
}
