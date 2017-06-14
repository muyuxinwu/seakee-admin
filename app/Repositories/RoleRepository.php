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
        return Role::destroy($id);
    }

    public function findRole($id)
    {
        return Role::find($id);
    }
}