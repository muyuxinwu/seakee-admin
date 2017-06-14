<?php
/**
 * File: IpRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/6/14 10:30
 * Description:
 */

namespace App\Repositories;

use App\Models\Ip\Ip;

use App\Interfaces\IpInterface;

class IpRepository implements IpInterface
{
    /**
     * @param array $userID
     * @param $ipAddress
     * @param int $state
     * @return bool
     */
    public function storageIP($userID, $ipAddress, $state = 2)
    {
        $ip = new Ip();

        $ip->user_id = $userID;
        $ip->state = $state;
        $ip->ip = $ipAddress;

        return $ip->save();
    }
}