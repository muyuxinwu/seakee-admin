<?php
/**
 * File: RouteInfoRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/6/14 15:47
 * Description:
 */

namespace App\Repositories;


use App\Interfaces\RouteInfoInterface;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class RouteInfoRepository implements RouteInfoInterface
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    /**
     * RouteInfoRepository constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    public function allAdminRouteListByGet()
    {
        $routes = $this->allRoutesByMethod('GET|HEAD');

        foreach ($routes as $key => $uri) {
            if (stripos($uri, 'admin/') !== false) {
                $list[$key] = $uri;
            }
        }

        return $list ?? [];
    }

    public function getRouteList()
    {
        return $this->getRoutes();
    }

    public function getAllRouteNameList()
    {
        return array_filter(array_column($this->getRoutes(), 'name'));
    }

    /**
     * Get all of the Routes(key => route name, value => uri) by method.
     *
     * @param string $method GET|HEAD,POST
     * @return array
     */
    protected function allRoutesByMethod($method = '')
    {
        $routeLists = $this->getRoutes();

        foreach ($routeLists as $key => $route) {
            if ($route['method'] == $method && !empty($route['name'])) {
                $routes[$route['name']] = $route['uri'];
            }
        }

        return $routes ?? [];
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return array
     */
    protected function getRoutes()
    {
        $routes = collect($this->routes)->map(function ($route) {
            return $this->getRouteInformation($route);
        })->all();

        return array_filter($routes);
    }

    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route $route
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        return [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    }
}