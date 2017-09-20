<?php
/**
 * File: IpInterface.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/6/14 10:26
 * Description:
 */

namespace App\Interfaces;

Interface IpInterface
{
	public function storageIP($userID, $ipAddress, $state);
}