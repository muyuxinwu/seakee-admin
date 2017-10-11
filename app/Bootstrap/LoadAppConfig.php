<?php
/**
 * File: Configuration.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2017/10/11 15:21
 * Description:加载自定义配置信息
 */

namespace App\Bootstrap;


use App\Support\Configuration;
use Illuminate\Contracts\Foundation\Application;

class LoadAppConfig
{
	/**
	 * @var Application
	 */
	protected $app;

	/**
	 * @var Configuration
	 */
	protected $configuration;

	/**
	 * LoadAppConfig constructor.
	 *
	 * @param Application   $app
	 * @param Configuration $configuration
	 */
	public function __construct(Application $app, Configuration $configuration)
	{
		$this->app           = $app;
		$this->configuration = $configuration;
	}

	/**
	 * Run handler, setting AppConfig.
	 */
	public function handle()
	{
		static $loaded = false;
		if ($loaded) {
			return;
		}

		$this->app->config->set($this->configuration->getAppConfig());
	}
}