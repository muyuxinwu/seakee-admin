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
    public function allUserWithPaginate($paginate);

    public function findUser($id);

    public function deleteUser($id);

    public function createUser($data);

    public function updateUser($data);
}
