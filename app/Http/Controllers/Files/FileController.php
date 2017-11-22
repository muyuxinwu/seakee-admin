<?php
/**
 * File: FileController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/11/20 21:22
 * Description:
 */

namespace App\Http\Controllers\Files;


use App\Http\Controllers\Controller;

class FileController extends Controller
{
	public function index()
	{
		return view('file.index');
	}
}