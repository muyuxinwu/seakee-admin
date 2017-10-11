<?php
/**
 * File: Application.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2017/10/11 15:14
 * Description:
 */

namespace App;

use App\Bootstrap\LoadAppConfig;
use Illuminate\Foundation\Application as App;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

class Application extends App
{
	/**
	 * 应用配置文件名称
	 */
	const configFile = '.config.yml';

	/**
	 * Application constructor.
	 *
	 * @param null $basePath
	 */
	public function __construct($basePath = null)
	{
		parent::__construct($basePath);

		$this->afterBootstrapping(LoadConfiguration::class, function ($app) {
			$app->make(LoadAppConfig::class)->handle();
		});
	}

	/**
	 * 应用配置文件完整路径
	 *
	 * @return string
	 */
	public function configFilePath(): string
	{
		return $this->environmentPath() . DIRECTORY_SEPARATOR . self::configFile;
	}
}