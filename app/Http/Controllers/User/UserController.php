<?php
/**
 * File: UserControllers.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 14:53
 * Description:
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(){
        return view('user.userIndex');
    }
}