<?php
/**
 * File: UserRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/17 15:50
 * Description:
 */

namespace App\Repositories;


use App\Interfaces\UserInterface;
use App\Models\User\User;

class UserRepository implements UserInterface
{
	/**
	 * 带分页用户列表
	 *
	 * @param $paginate
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function allWithPaginate($paginate)
	{
		return User::orderBy('created_at', 'desc')->paginate($paginate);
	}

	/**
	 * 返回指定用户
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function get($id)
	{
		return User::find($id);
	}

	/**
	 * 删除指定用户
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function delete($id)
	{
		return User::destroy($id);
	}

	/**
	 * 创建用户（基于Eloquent基本添加）
	 *
	 * @param array $data
	 *
	 * @return $this|\Illuminate\Database\Eloquent\Model
	 */
	public function store(array $data)
	{
		return User::create([
			'user_name' => $data['user_name'],
			'email'     => $data['email'],
			'password'  => bcrypt($data['password']),
		]);
	}

	/**
	 * 更新用户
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function update(array $data)
	{
		return User::where('id', $data['id'])->update($data);
	}

	/**
	 * 创建用户
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function storageUser(array $data)
	{
		$user = new User();

		$user->user_name = $data['user_name'];
		$user->email     = $data['email'];
		$user->password  = bcrypt($data['password']);

		if (isset($data['nick_name'])) {
			$user->nick_name = $data['nick_name'];
		}

		if (isset($data['avatar'])) {
			$user->avatar = $data['avatar'];
		}

		if (isset($data['phone'])) {
			$user->phone = $data['phone'];
		}

		return $user->save();
	}
}