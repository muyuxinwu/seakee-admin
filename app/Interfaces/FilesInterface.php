<?php
/**
 * File: FilesInterface.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top/
 * Date: 2017/12/12 17:21
 * Description:
 */

namespace App\Interfaces;


use Illuminate\Http\Request;

Interface FilesInterface
{
	/**
	 * 存储文件信息
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function store(array $data);

	/**
	 * 删除文件信息
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function delete($id);

	/**
	 * 更新文件信息
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function update(array $data);

	/**
	 * 带分页的文件列表
	 *
	 * @param array $condition
	 * @param       $paginate
	 *
	 * @return mixed
	 */
	public function allWithPaginate(array $condition, $paginate);

	/**
	 * 获取指定条件的文件
	 *
	 * @param array $condition
	 *
	 * @return mixed
	 */
	public function get(array $condition);

	/**
	 * 获取上传文件信息
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function info(Request $request);
}