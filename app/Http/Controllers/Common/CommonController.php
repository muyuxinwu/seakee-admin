<?php
/**
 * File: CommonController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2017/10/13 09:36
 * Description:
 */

namespace App\Http\Controllers\Common;


use App\Http\Controllers\Controller;
use App\Interfaces\CommonInterface;

class CommonController extends Controller
{
	/**
	 * Bing每日图片
	 *
	 * @param int             $idx 往前第$idx天
	 * @param int             $n 共$n张图片
	 * @param CommonInterface $common
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getBingImage($idx = 0, $n = 5, CommonInterface $common)
	{
		$bingImageUrls = $common->getBingImage($idx, $n);

		return response()->json([
			'status'  => 200,
			'message' => 'success',
			'list'    => $bingImageUrls,
		]);
	}
}