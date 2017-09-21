<?php

namespace App\Presenters\Admin;


use App\Interfaces\MenuInterface;
use Route;

class MenuPresenter
{
	/**
	 * @var MenuInterface
	 */
	private $menu;

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
	 * 边栏菜单列表
	 *
	 * @param $sidebarMenu
	 *
	 * @return mixed
	 */
	public function sidebarMenu($sidebarMenu)
	{
		$currentRouteName = explode('.', Route::currentRouteName());

		foreach ($sidebarMenu as $key => $menu) {

			$routeName = explode('.', $menu['route_name']);

			if ($currentRouteName[0] == $routeName[0]) {
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

		return $this->menu->menuTree($sidebarMenu);
	}
}