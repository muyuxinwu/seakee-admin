<?php

/**
 * File: PermissionInterface.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/22 10:59
 * Description:
 */

namespace App\Interfaces;

interface PermissionInterface
{
	/**
	 * 带有分页的权限列表
	 *
	 * @param $paginate
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function allWithPaginate($paginate);

	/**
	 * 创建权限
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function store($data);

	/**
	 * 更新权限
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function update($data);

	/**
	 * 获取指定ID的权限
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function get($id);

	/**
	 * 删除指定ID权限
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function delete($id);

	/**
	 * 获取所有权限
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all();

	/**
	 * 获取所有用户权限名
	 *
	 * @return array
	 */
	public function allName();

	/**
	 * 获取当前用户权限
	 *
	 * @param $user
	 *
	 * @return array
	 */
	public function currentUser($user);
}