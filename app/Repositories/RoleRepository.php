<?php
/**
 * File: RoleRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/18 17:59
 * Description:
 */

namespace App\Repositories;


use App\Interfaces\RoleInterface;
use App\Models\User\Role;
use Cache;

class RoleRepository implements RoleInterface
{

	/**
	 * 带有分页的角色列表
	 *
	 * @param $paginate
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function allRoleWithPaginate($paginate)
	{
		return Role::orderBy('created_at', 'desc')->paginate($paginate);
	}

	/**
	 * 新建角色
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createRole($data)
	{
		$role = new Role();

		$role->name         = $data['name'];
		$role->display_name = $data['display_name'];
		$role->description  = $data['description'];

		return $role->save();
	}

	/**
	 * 更新角色
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function updateRole($data)
	{
		return Role::where('id', $data['id'])->update($data);
	}

	/**
	 * 删除角色
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function deleteRole($id)
	{
		$role = Role::whereId($id);

		return $role->delete();
	}

	/**
	 * 通过角色ID查找角色
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function findRole($id)
	{
		return Role::find($id);
	}

	/**
	 * 所有角色列表
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function allRole()
	{
		return Role::all();
	}

	/**
	 * 当前用户的角色
	 *
	 * @param $user
	 *
	 * @return array
	 */
	public function currentUserRole($user)
	{
		return Cache::tags(['role', $user->id])->get('currentUserRole') ?: $this->putCurrentUserRoleCache($user);
	}

	/**
	 * 设置当前用户角色缓存
	 *
	 * @param $user
	 *
	 * @return array
	 */
	private function putCurrentUserRoleCache($user)
	{
		$currentUserRole = array_column($user->roles->toArray(), 'name', 'id');
		Cache::tags(['role', $user->id])->put('currentUserRole', $currentUserRole, config('cache.ttl'));

		return $currentUserRole;
	}
}