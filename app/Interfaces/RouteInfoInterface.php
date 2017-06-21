<?php
/**
 * File: RouteInfoInterface.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/6/14 15:43
 * Description:
 */

namespace App\Interfaces;

Interface RouteInfoInterface
{
    public function allAdminRouteListByGet();

    public function getAllRouteNameList();
    
    public function getRouteList();
}
