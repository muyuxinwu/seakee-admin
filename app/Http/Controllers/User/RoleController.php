<?php
/**
 * File: RoleController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 15:03
 * Description:
 */

namespace app\Http\Controllers\User;


use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index(){
        return view('user.roleIndex');
    }
}