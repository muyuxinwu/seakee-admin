<?php

namespace App\Models\User;

use Zizaco\Entrust\EntrustRole;
use DB;

class Role extends EntrustRole
{
    public static function getRoleIdList($userId){
        return DB::table('role_user')->select('role_id')->where('user_id', $userId)->get()->toArray();
    }
}
