<?php
/**
 * File: FileService.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/12/4 20:58
 * Description:文件相关操作服务
 */

namespace App\Services;


use Illuminate\Support\Facades\Storage;

class FileService
{
	/**
	 * 文件是否存在
	 *
	 * @param $filePath
	 *
	 * @return bool
	 */
	public function exists($filePath)
	{
		return Storage::exists($filePath);
	}

	/**
	 * 上传文件
	 *
	 * @param $filePath
	 * @param $content
	 *
	 * @return bool
	 */
	public function put($filePath, $content)
	{
		return Storage::put($filePath, $content);
	}

	/**
	 * 分段上传文件。建议大文件>10Mb使用。
	 *
	 * @param $filePath
	 * @param $resource
	 *
	 * @return bool
	 */
	public function putMass($filePath, $resource)
	{
		return Storage::put($filePath, fopen($resource, 'r+'));
	}

	/**
	 * 获取文件内容
	 *
	 * @param $filePath
	 *
	 * @return string
	 */
	public function get($filePath)
	{
		return Storage::get($filePath);
	}

	/**
	 * 删除文件
	 *
	 * @param $filePath
	 *
	 * @return bool
	 */
	public function delete($filePath)
	{
		return Storage::delete($filePath);
	}

	/**
	 * 复制文件到新的路径
	 *
	 * @param $oldPath
	 * @param $newPath
	 *
	 * @return bool
	 */
	public function copy($oldPath, $newPath)
	{
		return Storage::copy($oldPath, $newPath);
	}

	/**
	 * 移动文件到新的路径
	 *
	 * @param $oldPath
	 * @param $newPath
	 *
	 * @return bool
	 */
	public function move($oldPath, $newPath)
	{
		return Storage::move($oldPath, $newPath);
	}

	/**
	 * 取得文件大小
	 *
	 * @param $filePath
	 *
	 * @return int
	 */
	public function size($filePath)
	{
		return Storage::size($filePath);
	}

	/**
	 * 取得最近修改时间 (UNIX)
	 *
	 * @param $filePath
	 *
	 * @return int
	 */
	public function lastModified($filePath)
	{
		return Storage::lastModified($filePath);
	}

	/**
	 * 取得目录下所有文件
	 *
	 * @param $directory
	 *
	 * @return array
	 */
	public function files($directory)
	{
		return Storage::files($directory);
	}

	/**
	 * 创建目录
	 *
	 * @param $directory
	 *
	 * @return bool
	 */
	public function makeDirectory($directory)
	{
		return Storage::makeDirectory($directory);
	}

	/**
	 * 删除目录，包括目录下所有子文件子目录
	 *
	 * @param $directory
	 *
	 * @return bool
	 */
	public function deleteDirectory($directory)
	{
		return Storage::deleteDirectory($directory);
	}

	/**
	 * 返回文件的URL
	 *
	 * @param $filePath
	 *
	 * @return string
	 */
	public function url($filePath)
	{
		return Storage::url($filePath);
	}
}