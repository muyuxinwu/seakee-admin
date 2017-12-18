<?php
/**
 * File: FileController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/11/20 21:22
 * Description:
 */

namespace App\Http\Controllers\Files;


use App\Http\Controllers\Controller;
use App\Interfaces\FilesInterface;
use Illuminate\Http\Request;

class FileController extends Controller
{
	/**
	 * @var FilesInterface
	 */
	protected $file;

	/**
	 * File对应的数据库字段
	 */
	const fileKeys = [
		'name', 'type', 'path', 'disk', 'size', 'uploader','md5',
	];

	/**
	 * 服务器最大允许上传文件大小（单位M:M）
	 *
	 * @var string
	 */
	protected $upMaxSize;

	/**
	 * FileController constructor.
	 *
	 * @param FilesInterface $file
	 */
	public function __construct(FilesInterface $file)
	{
		$this->file      = $file;
		$this->upMaxSize = ini_get('upload_max_filesize');
	}

	/**
	 * 注册验证规则
	 *
	 * @return array
	 */
	protected function uploadRules()
	{
		return [
			'file' => 'size:',
		];
	}

	/**
	 * 验证失败后的返回信息
	 *
	 * @return array
	 */
	protected function validatorMessage()
	{
		return [
			'file.size' => '文件大小不能超过' . ini_get('upload_max_filesize'),
		];
	}

	/**
	 * 文件管理页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('file.index');
	}

	/**
	 * 上传文件接口
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function upload(Request $request)
	{
		$info = $this->file->info($request);

		$storage = $this->file->store($info);

		$rtnJson = [
			'status'  => 200,
			'message' => '上传成功',
		];

		if (!$storage){
			$rtnJson = [
				'status'  => 500,
				'message' => '上传失败',
			];
		}

		return response()->json($rtnJson);
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