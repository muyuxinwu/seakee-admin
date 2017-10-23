<?php
/**
 * File: ConfigController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2017/10/11 17:22
 * Description:
 */

namespace App\Http\Controllers\Configuration;


use App\Http\Controllers\Controller;
use Illuminate\Config\Repository;

class ConfigController extends Controller
{
	/**
	 * @var Repository
	 */
	protected $config;

	/**
	 * ConfigController constructor.
	 *
	 * @param Repository $config
	 */
	public function __construct(Repository $config)
	{
		$this->config = $config;
	}

	/**
	 * 系统配置页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('configuration.index');
	}

	/**
	 * 系统基础信息
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function app()
	{
		$data['name']        = $this->config->get('app.name', 'SKAdmin');
		$data['keywords']    = $this->config->get('app.keywords', '');
		$data['description'] = $this->config->get('app.description', '');
		$data['icp']         = $this->config->get('app.icp', '');
		$data['bingImage']   = $this->config->get('app.bingImage');

		return response()->json([
			'status'  => 200,
			'message' => 'success',
			'data'    => $data,
		]);
	}
}