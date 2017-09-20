<?php

namespace App\Presenters\Admin;


use App\Interfaces\MenuInterface;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;

class MenuPresenter
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
	 * MenuPresenter constructor.
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

	public function sidebarMenu()
	{

	}
}