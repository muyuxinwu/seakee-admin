<?php
/**
 * File: AdminController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/6 15:09
 * Description:
 */

namespace App\Http\Controllers;


class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$data['serverInfo'] = $this->serverInfo();

        return view('admin', $data);
    }

	/**
	 * 服务器信息
	 *
	 * @return array
	 */
	protected function serverInfo()
	{
		return [
			'phpVersion'     => PHP_VERSION,
			'os'             => PHP_OS,
			'server'         => $_SERVER['SERVER_SOFTWARE'],
			'db'             => $_ENV['DB_CONNECTION'],
			'root'           => $_SERVER['DOCUMENT_ROOT'],
			'laravelVersion' => app()::VERSION,
			'maxUploadSize'  => ini_get('upload_max_filesize'),
			'executeTime'    => ini_get('max_execution_time') . '秒',
			'serverDate'     => date('Y年n月j日 H:i:s'),
			'domainIp'       => $_SERVER['SERVER_NAME'] . ' / ' . $_SERVER['SERVER_ADDR'],
			'disk'           => round((disk_free_space('.') / (1024 * 1024 * 1024)), 2) . 'G',
		];
	}
}