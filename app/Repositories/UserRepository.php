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
    public function allUserWithPaginate($paginate)
    {
        return User::orderBy('created_at', 'desc')->paginate($paginate);
    }

    public function findUser($id)
    {
        return User::find($id);
    }

    public function deleteUser($id)
    {
        return User::destroy($id);
    }

    public function createUser(array $data)
    {
        return User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function updateUser(array $data)
    {
        $user = User::find($data['id']);

        $user->user_name = $data['user_name'];
        $user->email = $data['email'];

        if (isset($data['password']) && !empty($data['password'])){
            $user->password = bcrypt($data['password']);
        }

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
    
    public function storageUser(array $data)
    {
        $user = new User();

        $user->user_name = $data['user_name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);

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