<?php
/**
 * File: RequestParamsService.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/9/20 17:50
 * Description:
 */

namespace App\Services;


class RequestParamsService
{
	/**
	 * 获取指定key的输入值，并过滤空值项
	 *
	 * @param $paramKeys
	 * @param $request
	 *
	 * @return array
	 */
	public function params($paramKeys, $request)
	{
		foreach ($paramKeys as $key) {
			if ($request->filled($key)) {
				$data[$key] = $request->input($key);
			}
		}

		return $data ?? [];
	}
}