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
use Illuminate\Http\Request;

class CommonController extends Controller
{
	/**
	 * Bing每日图片
	 *
	 * @param Request         $request
	 * @param CommonInterface $common
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getBingImage(Request $request, CommonInterface $common)
	{
		$idx = $request->input('idx', 0);
		$n = $request->input('idx', 1);

		$bingImageUrls = $common->getBingImage($idx, $n);

		return response()->json([
			'status'  => 200,
			'message' => 'success',
			'list'    => $bingImageUrls,
		]);
	}
}