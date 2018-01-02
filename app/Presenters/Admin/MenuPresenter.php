<?php

namespace App\Presenters\Admin;


use App\Interfaces\MenuInterface;
use Route;

class MenuPresenter
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
	 * 边栏菜单列表
	 *
	 * @param $sidebarMenu
	 *
	 * @return mixed
	 */
	public function sidebarMenu($sidebarMenu)
	{
		$currentRoutePrefix = $this->routePrefix(Route::currentRouteName());

		foreach ($sidebarMenu as $key => $menu) {

			$routePrefix = $this->routePrefix($menu['route_name']);

			if ($currentRoutePrefix == $routePrefix) {
				$menu['class']     = 'active';
				$sidebarMenu[$key] = $menu;
				$fatherMenus       = &$sidebarMenu;

				if ($menu['father_id'] != -1) {
					foreach ($fatherMenus as $fatherKey => $fatherMenu) {
						if ($fatherMenu['id'] == $menu['father_id']) {
							$fatherMenu['class'] = 'active';
						}

						$fatherMenus[$fatherKey] = $fatherMenu;
					}
				}
			}
		}

		return $this->menu->tree($sidebarMenu);
	}
}