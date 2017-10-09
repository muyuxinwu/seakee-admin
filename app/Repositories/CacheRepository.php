<?php
/**
 * File: CacheRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/10/9 16:51
 * Description:
 */

namespace App\Repositories;


use App\Interfaces\CacheInterface;
use Cache;

class CacheRepository implements CacheInterface
{
	/**
	 * 清空所有缓存
	 *
	 * @return bool
	 */
	public function clearAll()
	{
		return Cache::flush();
	}

	/**
	 * 清空系统菜单缓存
	 *
	 * @return bool
	 */
	public function clearMenu()
	{
		return Cache::forget('allMenus');
	}

	/**
	 * 清空指定用户的菜单缓存
	 *
	 * @param $userId
	 */
	public function clearUserMenu($userId)
	{
		Cache::tags(['menu', $userId])->flush();
	}

	/**
	 * 清空所有用户的菜单缓存
	 */
	public function clearAllUserMenu()
	{
		Cache::tags('menu')->flush();
	}

	/**
	 * 清空指定用户的角色缓存
	 *
	 * @param $userId
	 */
	public function clearUserRole($userId)
	{
		Cache::tags(['role', $userId])->flush();
	}

	/**
	 * 清空所有用户的角色缓存
	 */
	public function clearAllUserRole()
	{
		Cache::tags('role')->flush();
	}

	/**
	 * 清空系统权限缓存
	 */
	public function clearPermission()
	{
		Cache::forget('allPermission');
	}

	/**
	 * 清空指定用户的权限缓存
	 *
	 * @param $userId
	 */
	public function clearUserPermission($userId)
	{
		Cache::tags(['permission', $userId])->flush();
	}

	/**
	 * 清空所有用户的权限缓存
	 */
	public function clearAllUserPermission()
	{
		Cache::tags('permission')->flush();
	}
}