<?php
/**
 * File: RoleInterface.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/18 17:52
 * Description:
 */

namespace App\Interfaces;

interface RoleInterface
{
	/**
	 * 带有分页的角色列表
	 *
	 * @param $paginate
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function allWithPaginate($paginate);

	/**
	 * 新建角色
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function store($data);

	/**
	 * 更新角色
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function update($data);

	/**
	 * 通过角色ID查找角色
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function get($id);

	/**
	 * 删除角色
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function delete($id);

	/**
	 * 所有角色列表
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all();

	/**
	 * 当前用户的角色
	 *
	 * @param $user
	 *
	 * @return array
	 */
	public function currentUser($user);
}
