<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Ip\Ip;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * save IP
     * @param $userID
     * @param $ipAddress
     * @param int $state
     * @return bool
     */
    protected function saveIP($userID, $ipAddress, $state = 2)
    {
        $ip = new Ip();

        $ip->user_id = $userID;
        $ip->state = $state;
        $ip->ip = $ipAddress;

        return $ip->save();
    }

    /**
     * get all of routes
     * @return mixed
     */
    protected function getRoute()
    {
        $route = Route::getRoutes()->getRoutesByMethod();
        return $route;
    }
}
