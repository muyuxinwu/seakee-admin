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
    public function allPermissionWithPaginate($paginate);

    public function createPermission($data);

    public function updatePermission($data);

    public function findPermission($id);

    public function deletePermission($id);

    public function allPermission();
}