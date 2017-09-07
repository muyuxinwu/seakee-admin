<?php

namespace App\Models\User;

use Zizaco\Entrust\EntrustPermission;
use DB;

class Permission extends EntrustPermission
{
    public static function getPermissionIdList($roleId){
        return DB::table('permission_role')->select('permission_id')->whereIn('role_id', $roleId)->get()->toArray();
    }
}
