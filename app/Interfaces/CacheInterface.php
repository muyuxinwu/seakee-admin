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
	/**
	 * 清空所有缓存
	 *
	 * @return bool
	 */
	public function clearAll();

	/**
	 * 清空系统菜单缓存
	 *
	 * @return bool
	 */
	public function clearMenu();

	/**
	 * 清空指定用户的菜单缓存
	 *
	 * @param $userId
	 */
	public function clearUserMenu($userId);

	/**
	 * 清空所有用户的菜单缓存
	 */
	public function clearAllUserMenu();

	/**
	 * 清空指定用户的角色缓存
	 *
	 * @param $userId
	 */
	public function clearUserRole($userId);

	/**
	 * 清空所有用户的角色缓存
	 */
	public function clearAllUserRole();

	/**
	 * 清空系统权限缓存
	 */
	public function clearPermission();

	/**
	 * 清空指定用户的权限缓存
	 *
	 * @param $userId
	 */
	public function clearUserPermission($userId);

	/**
	 * 清空所有用户的权限缓存
	 */
	public function clearAllUserPermission();
}