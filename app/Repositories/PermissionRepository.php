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

class PermissionRepository implements PermissionInterface
{
    public function allPermissionWithPaginate($paginate)
    {
        return Permission::orderBy('created_at', 'desc')->paginate($paginate);
    }

    public function createPermission($data)
    {
        $permission = new Permission();

        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];
        $permission->description = $data['description'];

        return $permission->save();
    }

    public function updatePermission($data)
    {
        $permission = Permission::find($data['id']);

        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];
        $permission->description = $data['description'];

        return $permission->save();
    }

    public function deletePermission($id)
    {
        return Permission::destroy($id);
    }

    public function findPermission($id)
    {
        return Permission::find($id);
    }

    public function allPermission()
    {
        return Permission::all();
    }

    public function allPermissionName()
    {
        return array_column($this->allPermission()->toArray(), 'name', 'id');
    }

    public function currentUserPermission($roleId, $allPermissionName)
    {
        $permissionIdList = array_column(Permission::getPermissionIdList($roleId), 'permission_id');

        $currentUserPermission = [];
        foreach ($permissionIdList as $item) {
            $currentUserPermission[] = $allPermissionName[$item];
        }

        return $currentUserPermission;
    }
}