<?php
/**
 * File: MenuInterface.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/16 10:55
 * Description:
 */

namespace App\Interfaces;

Interface MenuInterface
{
	public function allMenus();

	public function allWithoutCache();

	public function findMenu($id);

	public function deleteMenu($id);

	public function createMenu(array $data);

	public function updateMenu(array $data);

	public function menuCount(array $data);

	public function menuTree($menu);

	public function currentUserMenu($currentUserPermission, $roles);
}


