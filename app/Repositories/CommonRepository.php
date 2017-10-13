<?php
/**
 * File: CommonRepository.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2017/10/12 17:01
 * Description:
 */

namespace App\Repositories;


use App\Interfaces\CommonInterface;
use GuzzleHttp\Client;

class CommonRepository implements CommonInterface
{
	//Bing Url
	const bingUrl = 'http://cn.bing.com';

	/**
	 * Bing每日图片
	 *
	 * @param int $idx 往前第$idx天
	 * @param int $n 共$n张图片
	 *
	 * @return array
	 */
	public function getBingImage($idx = 0, $n = 5)
	{
		$data['format'] = 'js';
		$data['idx']    = $idx;
		$data['n']      = $n;

		$client = new Client(['base_uri' => self::bingUrl]);

		$response = $client->request('GET', '/HPImageArchive.aspx', ['query' => $data]);
		$body     = json_decode($response->getBody()->getContents(), true);
		$urls     = array_pluck(head($body), 'url');

		foreach ($urls as $url){
			$imageUrls[] = self::bingUrl . $url;
		}

		return $imageUrls ?? [];
	}
}