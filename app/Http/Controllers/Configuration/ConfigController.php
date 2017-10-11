<?php
/**
 * File: ConfigController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2017/10/11 17:22
 * Description:
 */

namespace App\Http\Controllers\Configuration;


use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
	public function index(){
		return view('configuration.index');
	}
}