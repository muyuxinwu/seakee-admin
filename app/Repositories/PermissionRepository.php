<?php
/**
 * File: PermissionRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/22 11:01
 * Description:
 */

namespace App\Repositories;

use App\Interfaces\PermissionInterface;
use App\Models\User\Permission;
use Cache;

class PermissionRepository implements PermissionInterface {

	/**
	 * 带有分页的权限列表
	 * 
	 * @param $paginate
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function allPermissionWithPaginate( $paginate ) {
		return Permission::orderBy( 'created_at', 'desc' )->paginate( $paginate );
	}

	/**
	 * 创建权限
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function createPermission( $data ) {
		$permission = new Permission();

		$permission->name         = $data['name'];
		$permission->display_name = $data['display_name'];
		$permission->description  = $data['description'];

		return $permission->save();
	}

	/**
	 * 更新权限
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function updatePermission( $data ) {
		$permission = Permission::find( $data['id'] );

		$permission->name         = $data['name'];
		$permission->display_name = $data['display_name'];
		$permission->description  = $data['description'];

		return $permission->save();
	}

	/**
	 * 删除权限
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function deletePermission( $id ) {
		return Permission::destroy( $id );
	}

	/**
	 * 根据权限ID查找权限
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function findPermission( $id ) {
		return Permission::find( $id );
	}

	/**
	 * 获取所有权限
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function allPermission() {
		return Permission::all();
	}

	/**
	 * 获取所有用户权限名
	 *
	 * @return array
	 */
	public function allPermissionName() {
		return Cache::get( 'allPermission' ) ?: $this->putAllPermissionCache();
	}

	/**
	 * 获取当前用户权限
	 *
	 * @param $user
	 *
	 * @return array
	 */
	public function currentUserPermission( $user ) {
		return Cache::tags( [
			'user',
			$user->id
		] )->get( 'currentUserPermission' ) ?: $this->putCurrentUserPermissionCache( $user );
	}

	/**
	 * 设置所有权限缓存
	 *
	 * @return array
	 */
	private function putAllPermissionCache() {
		$allPermission = array_column( $this->allPermission()->toArray(), 'name', 'id' );
		Cache::put( 'allPermission', $allPermission, 10 );

		return $allPermission;
	}

	/**
	 * 设置当前用户权限缓存
	 *
	 * @param $user
	 *
	 * @return array
	 */
	private function putCurrentUserPermissionCache( $user ) {
		$roles            = head( $user->with( 'roles.perms' )->get()->pluck( 'roles' )->toArray() );
		$permissionIdList = array_pluck( $roles, 'perms' );

		$currentUserPermission = [];
		foreach ( $permissionIdList as $item ) {
			$currentUserPermission += array_column( $item, 'name', 'id' );
		}

		Cache::tags( [ 'user', $user->id ] )->put( 'currentUserPermission', $currentUserPermission, 10 );

		return $currentUserPermission;
	}
}