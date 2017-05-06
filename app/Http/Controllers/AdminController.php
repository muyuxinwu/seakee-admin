<?php
/**
 * File: AdminController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/6 15:09
 * Description:
 */

namespace App\Http\Controllers;


class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }
}