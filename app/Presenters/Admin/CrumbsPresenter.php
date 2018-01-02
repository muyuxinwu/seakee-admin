<?php

namespace App\Presenters\Admin;


use App\Interfaces\MenuInterface;
use Route;

class CrumbsPresenter
{
	/**
	 * @var MenuInterface
	 */
	protected $menu;

	/**
	 * MenuPresenter constructor.
	 *
	 * @param MenuInterface $menu
	 */
	public function __construct(MenuInterface $menu)
	{
		$this->menu = $menu;
	}

	/**
	 * 获取路由前缀
	 *
	 * @param $routeName
	 *
	 * @return mixed
	 */
	protected function routePrefix($routeName)
	{
		return head(explode('.', $routeName));
	}

	/**
	 * 面包屑菜单
	 *
	 * @return string
	 */
	public function crumbsMenu()
	{
		$allMenu = $this->menu->all();

		$currentRoutePrefix = $this->routePrefix(Route::currentRouteName());

		foreach ($allMenu as $key => $menu) {
			$routePrefix = $this->routePrefix($menu['route_name']);

			if ($currentRoutePrefix == $routePrefix) {
				$crumbsChild = $menu;
				$fatherMenus = &$allMenu;

				if ($menu['father_id'] != -1) {
					foreach ($fatherMenus as $fatherKey => $fatherMenu) {
						if ($fatherMenu['id'] == $menu['father_id']) {
							$crumbsFather = $fatherMenu;
						}
					}
				}
			}
		}

		if (!empty($crumbsChild) && !empty($crumbsFather)) {
			$menu = '<li><a href="#"><i class="fa ' . $crumbsFather['icon'] . '"></i>' . $crumbsFather['menu_name'] . '</a></li>';
			$menu .= '<li><a href="' . route($crumbsChild['route_name']) . '">' . $crumbsChild['menu_name'] . '</a></li>';
		} else {
			$menu = '<li><a href="#"><i class="fa fa-circle-o"></i>SKAdmin</a></li>';
		}

		return $menu;
	}
}