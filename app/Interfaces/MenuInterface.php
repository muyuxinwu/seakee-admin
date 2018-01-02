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
	/**
	 * 返回所有菜单（有缓存）
	 *
	 * @return array
	 */
	public function all();

	/**
	 * 返回所有菜单（无缓存）
	 *
	 * @return array
	 */
	public function allWithoutCache();

	/**
	 * 获取指定菜单
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function get($id);

	/**
	 * 删除指定菜单
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function delete($id);

	/**
	 * 存储菜单
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function store(array $data);

	/**
	 * 更新指定菜单
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function update(array $data);

	/**
	 * 查询菜单数目
	 *
	 * @param array $data
	 *
	 * @return int
	 */
	public function count(array $data);

	/**
	 * 获取菜单树形数组
	 *
	 * @param     $menu
	 *
	 * @return array|string
	 */
	public function tree($menu);

	/**
	 * 获取当前用户菜单
	 *
	 * @param $currentUserPermission
	 * @param $user
	 *
	 * @return array
	 */
	public function currentUser($currentUserPermission, $user);
}


