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
    public function allRoleWithPaginate($paginate)
    {
        return Role::orderBy('created_at', 'desc')->paginate($paginate);
    }

    public function createRole($data)
    {
        $role = new Role();

        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];

        return $role->save();
    }

    public function updateRole($data)
    {
        $role = Role::find($data['id']);

        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];

        return $role->save();
    }

    public function deleteRole($id)
    {
        $role = Role::whereId($id);

        return $role->delete();
    }

    public function findRole($id)
    {
        return Role::find($id);
    }

    public function allRole()
    {
        return Role::all();
    }

    public function currentUserRole($userId)
    {
        return Cache::tags(['user', $userId])->get('currentUserRole') ?: $this->putCurrentUserRoleCache($userId);
    }
    
    private function putCurrentUserRoleCache($userId){
        $currentUserRole = array_column(Role::getRoleIdList($userId), 'role_id');
        Cache::tags(['user', $userId])->put('currentUserRole', $currentUserRole, 10);
        return $currentUserRole;
    }
}