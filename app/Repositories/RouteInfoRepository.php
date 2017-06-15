<?php
/**
 * File: RouteInfoRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/6/14 15:47
 * Description:
 */

namespace App\Repositories;


use App\Interfaces\RouteInfoInterface;
use Illuminate\Support\Facades\Route;

class RouteInfoRepository implements RouteInfoInterface
{
    public function allAdminRouteListByGet()
    {
        $routes = $this->allRoutesByMethod('GET');

        foreach ($routes as $key => $route) {
            $route = (array)$route;
            $routeName = isset($route['action']['as']) ? $route['action']['as'] : '';
            if (stripos($key, 'admin/') !== false) {
                $list[$routeName] = $key;
            }
        }
        
        return $list ?? [];
    }

    private function allRoutesByMethod($method = '')
    {
        $routes = Route::getRoutes()->getRoutesByMethod();

        switch ($method) {
            case 'GET':
                return $routes['GET'];
            case 'POST':
                return $routes['POST'];
            default :
                return $routes;
        }
    }
}