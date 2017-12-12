<?php
/**
 * File: FilesInterface.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top/
 * Date: 2017/12/12 17:21
 * Description:
 */

namespace App\Interfaces;


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
	 * @param array $where
	 * @param       $paginate
	 *
	 * @return mixed
	 */
	public function allWithPaginate(array $where, $paginate);

	/**
	 * 获取指定条件的文件
	 *
	 * @param array $where
	 *
	 * @return mixed
	 */
	public function get(array $where);
}