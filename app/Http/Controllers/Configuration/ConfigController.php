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
		'name',
		'keywords',
		'description',
		'icp',
		'bingImage',
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

		foreach ($configData as $key => $value) {
			$config['app.' . $key] = $value;
		}

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