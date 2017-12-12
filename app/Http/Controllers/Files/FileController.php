<?php
/**
 * File: FileController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/11/20 21:22
 * Description:
 */

namespace App\Http\Controllers\Files;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
	public function index()
	{
		return view('file.index');
	}

	public function upload(Request $request)
	{
		var_dump($request->file('file'));exit();
	}

	/**
	 * 获取磁盘列表
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getDisk()
	{
		list($disk) = array_divide(config('filesystems.disks'));

		return response()->json([
			'status'  => 200,
			'message' => 'success',
			'data'    => $disk,
		]);
	}
}