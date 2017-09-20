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

	public function updateUser(array $data);

	/**
	 * @param array $data
	 *
	 * @return Object User
	 */
	public function createUser(array $data);

	/**
	 * @param array $data
	 *
	 * @return bool
	 */
	public function storageUser(array $data);
}
