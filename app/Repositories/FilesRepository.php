<?php
/**
 * File: FilesRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top/
 * Date: 2017/12/12 17:43
 * Description:
 */

namespace App\Repositories;


use App\Interfaces\FilesInterface;
use App\Models\Files\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesRepository implements FilesInterface
{
	/**
	 * 带分页的文件列表
	 *
	 * @param array $condition
	 * @param       $paginate
	 *
	 * @return mixed
	 */
	public function allWithPaginate(array $condition, $paginate = 10)
	{
		$where = self::setWhere($condition);

		return Files::where($where)->orderBy('created_at', 'desc')->paginate($paginate);
	}

	/**
	 * 设置搜索条件
	 *
	 * @param array $condition
	 *
	 * @return array
	 */
	protected function setWhere(array $condition)
	{
		foreach ($condition as $key => $value){
			if ($key == 'type' || $key == 'name'){
				$where[] = [$key, 'like', $value];
			} else {
				$where[] = [$key, '=', $value];
			}
		}

		return $where ?? [];
	}

	/**
	 * 获取指定条件的文件
	 *
	 * @param array $condition
	 *
	 * @return mixed
	 */
	public function get(array $condition)
	{
		return Files::where($condition)->get()->toArray();
	}

	/**
	 * 更新文件信息
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function update(array $data)
	{
		return Files::where('id', $data['id'])->update($data);
	}

	/**
	 * 删除文件信息
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function delete($id)
	{
		return Files::destroy($id);
	}

	/**
	 * 存储文件信息
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function store(array $data)
	{
		return Files::create($data);
	}

	/**
	 * 获取上传文件信息
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function info(Request $request):array
	{
		$disk      = $request->input('disk');
		$file      = $request->file('file');
		$directory = date('Y/m/d');

		$info['disk'] = $disk;
		$info['md5']  = md5_file($file);

		$fileInfo = head(self::get($info));

		//如果指定磁盘已经存储过文件，则直接使用已存储过的路径
		if (!empty($fileInfo) && Storage::exists($fileInfo['path'])){
			$info['path'] = $fileInfo['path'];
		} else {
			$info['path'] = $file->store($directory, $disk);
		}

		$info['name'] = $file->getClientOriginalName();
		$info['type'] = $file->getMimeType();
		$info['size'] = $file->getSize();


		$info['uploader'] = $request->user()->id;

		return $info;
	}
}