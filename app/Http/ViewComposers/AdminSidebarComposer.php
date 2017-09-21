<?php
/**
 * File: AdminSidebarComposer.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/16 17:14
 * Description:
 */

namespace App\Http\ViewComposers;


use App\Interfaces\MenuInterface;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use Illuminate\View\View;

class AdminSidebarComposer
{
	/**
	 * @var MenuInterface
	 */
	private $menu;

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
	 * @param MenuInterface       $menu
	 * @param RoleInterface       $role
	 * @param PermissionInterface $permission
	 */
	public function __construct(MenuInterface $menu, RoleInterface $role, PermissionInterface $permission)
	{
		$this->menu       = $menu;
		$this->role       = $role;
		$this->permission = $permission;
	}

	/**
	 * @param View $view
	 */
	public function compose(View $view)
	{
		$view->with('sidebarMenu', $this->getCurrentUserMenu());
	}

	private function getCurrentUserMenu()
	{
		$user              = session('user');
		$userData['id']    = $user->id;
		$userData['roles'] = $this->role->currentUserRole($user);

		//当前用户角色为超级管理员时，显示所有菜单
		if (in_array('Super_Admin', $userData['roles'])) {
			$currentUserMenu = $this->menu->allMenus();
		} else {
			$currentUserPermission = $this->permission->currentUserPermission($user);
			$currentUserMenu       = $this->menu->currentUserMenu($currentUserPermission, $userData);
		}

		return $this->menu->menuTree($currentUserMenu);
	}
}