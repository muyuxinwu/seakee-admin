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
    public function allRoleWithPaginate($paginate);

    public function createRole($data);

    public function updateRole($data);

    public function findRole($id);

    public function deleteRole($id);

    public function allRole();
}
