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

class RoleRepository implements RoleInterface {

	/**
	 * 带有分页的权限列表
	 *
	 * @param $paginate
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function allRoleWithPaginate( $paginate ) {
		return Role::orderBy( 'created_at', 'desc' )->paginate( $paginate );
	}

	/**
	 * 新建权限
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createRole( $data ) {
		$role = new Role();

		$role->name         = $data['name'];
		$role->display_name = $data['display_name'];
		$role->description  = $data['description'];

		return $role->save();
	}

	/**
	 * 更新权限
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function updateRole( $data ) {
		$role = Role::find( $data['id'] );

		$role->name         = $data['name'];
		$role->display_name = $data['display_name'];
		$role->description  = $data['description'];

		return $role->save();
	}

	/**
	 * 删除权限
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function deleteRole( $id ) {
		$role = Role::whereId( $id );

		return $role->delete();
	}

	/**
	 * 通过权限ID查找权限
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function findRole( $id ) {
		return Role::find( $id );
	}

	/**
	 * 所有权限列表
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function allRole() {
		return Role::all();
	}

	/**
	 * 当前用户的权限
	 *
	 * @param $user
	 *
	 * @return array
	 */
	public function currentUserRole( $user ) {
		return Cache::tags( [
			'user',
			$user->id
		] )->get( 'currentUserRole' ) ?: $this->putCurrentUserRoleCache( $user );
	}

	/**
	 * 设置当前用户权限缓存
	 *
	 * @param $user
	 *
	 * @return array
	 */
	private function putCurrentUserRoleCache( $user ) {
		$currentUserRole = array_column( $user->roles->toArray(), 'name', 'id' );
		Cache::tags( [ 'user', $user->id ] )->put( 'currentUserRole', $currentUserRole, 10 );

		return $currentUserRole;
	}
}