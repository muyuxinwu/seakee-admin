<?php
/**
 * File: MenuRepository.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/16 11:00
 * Description:
 */

namespace App\Repositories;

use App\Interfaces\MenuInterface;
use App\Models\Menu\Menu;
use Cache;

class MenuRepository implements MenuInterface
{
	/**
	 * 返回所有菜单（无缓存）
	 *
	 * @return array
	 */
	public function allWithoutCache()
	{
		return Menu::all()->toArray();
	}

	/**
	 * 返回所有菜单（有缓存）
	 *
	 * @return array
	 */
	public function allMenus()
	{
		return Cache::get('allMenus') ?: $this->putAllMenuCache();
	}

	/**
	 * 获取指定菜单
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function findMenu($id)
	{
		return Menu::find($id);
	}

	/**
	 * 删除指定菜单
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function deleteMenu($id)
	{
		return Menu::destroy($id);
	}

	/**
	 * 创建菜单
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function createMenu(array $data)
	{
		$menu = new Menu();

		$menu->menu_name  = $data['menu_name'];
		$menu->route_name = $data['route_name'];
		$menu->icon       = $data['icon'];
		$menu->is_custom  = $data['is_custom'];
		$menu->father_id  = $data['father_id'];
		$menu->sort       = $data['sort'];
		$menu->display    = $data['display'];
		$menu->state      = $data['state'];

		return $menu->save();
	}

	/**
	 * 更新指定菜单
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function updateMenu(array $data)
	{
		return Menu::where('id', $data['id'])->update($data);
	}

	/**
	 * 查询菜单数目
	 *
	 * @param array $data
	 *
	 * @return int
	 */
	public function menuCount(array $data)
	{
		return Menu::where($data)->count();
	}

	/**
	 * 获取菜单树形数组
	 *
	 * @param     $menu
	 * @param int $father_id
	 *
	 * @return array|string
	 */
	public function menuTree($menu, $father_id = -1)
	{
		return $this->setMenuTree($menu, $father_id);
	}

	/**
	 * 设置菜单树形数组
	 *
	 * @param $menuList
	 * @param $father_id
	 *
	 * @return array|string
	 */
	private function setMenuTree(&$menuList, $father_id)
	{
		if (!empty($menuList)) {
			foreach ($menuList as $menu) {
				$menu             = (array)$menu;
				$menu['menu_url'] = $this->_getMenuUrl($menu);
				if ($menu['father_id'] == $father_id) {
					$nodes    = $this->setMenuTree($menuList, $menu['id']);
					$result[] = empty($nodes) ? $menu : array_merge($menu, ['nodes' => $nodes]);
				}
			}
		}

		return $result ?? '';
	}

	/**
	 * 获取菜单Url
	 *
	 * @param array $menu
	 *
	 * @return string
	 */
	private function _getMenuUrl(array $menu)
	{
		$menuUrl = $menu['route_name'];

		if ($menu['is_custom'] == 0 && $menu['route_name'] != '#') {
			$menuUrl = route($menu['route_name'], [], false);
		}

		return $menuUrl;
	}

	/**
	 * 获取当前用户菜单
	 *
	 * @param $currentUserPermission
	 * @param $user
	 *
	 * @return array
	 */
	public function currentUserMenu($currentUserPermission, $user)
	{
		return Cache::tags([
			'user',
			$user['id'],
		])->get('currentUserMenu') ?: $this->putCurrentUserMenuCache($currentUserPermission, $user);
	}

	/**
	 * 设置当前用户菜单缓存
	 *
	 * @param $currentUserPermission
	 * @param $user
	 *
	 * @return array
	 */
	private function putCurrentUserMenuCache($currentUserPermission, $user)
	{
		$allMenu = $this->allMenus();

		if (!in_array('Super_Admin', $user['roles'])) {
			foreach ($allMenu as $menu) {
				if (in_array($menu['route_name'], $currentUserPermission)) {
					//查找父菜单
					if ($menu['father_id'] != -1) {
						foreach ($allMenu as $m) {
							if ($menu['father_id'] == $m['id']){
								$currentUserMenu[] = $m;
							}
						}
					}
					$currentUserMenu[] = $menu;
				}
			}
		}

		Cache::tags([
			'user',
			$user['id'],
		])->put('currentUserMenu', $currentUserMenu ?? $allMenu, 10);

		return $currentUserMenu ?? $allMenu;
	}

	/**
	 * 设置所有菜单缓存
	 *
	 * @return array
	 */
	private function putAllMenuCache()
	{
		$allMenu = Menu::where('display', 1)->orderBy('sort', 'desc')->get()->toArray();

		Cache::put('allMenus', $allMenu, 10);

		return $allMenu;
	}
}