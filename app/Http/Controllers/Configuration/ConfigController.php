<?php
/**
 * File: ConfigController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2017/10/11 17:22
 * Description:配置相关
 */

namespace App\Http\Controllers\Configuration;


use App\Http\Controllers\Controller;
use App\Services\RequestParamsService;
use App\Support\Configuration;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
	/**
	 * @var Repository
	 */
	protected $config;

	/**
	 * @var RequestParamsService
	 */
	protected $requestParams;

	/**
	 * 配置字段
	 */
	const configKeys = [
		'app_name',
		'app_keywords',
		'app_description',
		'app_icp',
		'app_bingImage',
	];

	/**
	 * ConfigController constructor.
	 *
	 * @param Repository           $config
	 * @param RequestParamsService $params
	 */
	public function __construct(Repository $config, RequestParamsService $params)
	{
		$this->config        = $config;
		$this->requestParams = $params;
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
	 * 更新配置信息
	 *
	 * @param Request       $request
	 * @param Configuration $configuration
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, Configuration $configuration)
	{
		$configData = $this->requestParams->params(self::configKeys, $request);

		$config = array_key_to_dot($configData);

		$configuration->set($config);

		return response()->json([
			'status'  => 200,
			'message' => 'success',
		]);
	}

	/**
	 * 系统基础信息
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function app()
	{
		$data['name']        = $this->config->get('app.name', 'SKAdmin');
		$data['keywords']    = $this->config->get('app.keywords', 'SKAdmin,Laravel,AdminLTE');
		$data['description'] = $this->config->get('app.description', 'SKAdmin是基于Laravel5.5的后台管理脚手架');
		$data['icp']         = $this->config->get('app.icp', '');
		$data['bingImage']   = $this->config->get('app.bingImage', 0);

		return response()->json([
			'status'  => 200,
			'message' => 'success',
			'data'    => $data,
		]);
	}
}