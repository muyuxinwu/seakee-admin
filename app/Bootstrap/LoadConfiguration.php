<?php
/**
 * File: LoadConfiguration.phpion.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/15 10:29
 * Description:
 */

namespace App\Bootstrap;

use App\Support\Configuration;
use Illuminate\Contracts\Foundation\Application;

class LoadConfiguration
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
		$this->app->config->set($this->configuration->getAppConfig());
	}
}