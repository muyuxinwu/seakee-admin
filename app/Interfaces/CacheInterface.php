<?php
/**
 * File: CacheInterface.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/10/9 16:50
 * Description:
 */

namespace App\Interfaces;


Interface CacheInterface
{
	public function clearAll();

	public function clearMenu();

	public function clearUserMenu($userId);

	public function clearAllUserMenu();

	public function clearUserRole($userId);

	public function clearAllUserRole();

	public function clearPermission();

	public function clearUserPermission($userId);

	public function clearAllUserPermission();
}