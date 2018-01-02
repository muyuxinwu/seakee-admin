<?php
/**
 * File: UserInterface.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/17 14:48
 * Description:
 */

namespace App\Interfaces;

Interface UserInterface
{
	/**
	 * 带分页用户列表
	 *
	 * @param $paginate
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function allWithPaginate($paginate);

	/**
	 * 返回指定用户
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function get($id);

	/**
	 * 删除指定用户
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function delete($id);

	/**
	 * 更新用户
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function update(array $data);


	/**
	 * 创建用户（基于Eloquent基本添加）
	 *
	 * @param array $data
	 *
	 * @return $this|\Illuminate\Database\Eloquent\Model
	 */
	public function store(array $data);

	/**
	 * 创建用户
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function storageUser(array $data);
}
