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
    public function allMenus()
    {
        return Cache::get('allMenus') ?: $this->putAllMenuCache();
    }

    public function findMenu($id)
    {
        return Menu::find($id);
    }

    public function deleteMenu($id)
    {
        return Menu::destroy($id);
    }

    public function createMenu(array $data)
    {
        $menu = new Menu();

        $menu->menu_name = $data['menuName'];
        $menu->route_name = $data['routeName'];
        $menu->icon = $data['icon'];
        $menu->is_custom = $data['isCustom'];
        $menu->father_id = $data['fatherMenu'];
        $menu->sort = $data['menuSort'];
        $menu->display = $data['menuDisplay'];
        $menu->state = $data['menuState'];

        return $menu->save();
    }

    public function updateMenu(array $data)
    {
        $menu = Menu::find($data['id']);

        $menu->menu_name = $data['menuName'];
        $menu->route_name = $data['routeName'];
        $menu->icon = $data['icon'];
        $menu->is_custom = $data['isCustom'];
        $menu->father_id = $data['fatherMenu'];
        $menu->sort = $data['menuSort'];
        $menu->display = $data['menuDisplay'];
        $menu->state = $data['menuState'];

        return $menu->save();
    }

    public function menuCount(array $data)
    {
        return Menu::where($data)->count();
    }

    public function menuTree($menu, $father_id = -1)
    {
        return $this->getMenuTree($menu, $father_id);
    }

    /**
     * return menu tree
     * @param $menuList
     * @param $father_id
     * @return array|string
     */
    private function getMenuTree(&$menuList, $father_id)
    {
        if (!empty($menuList)) {
            foreach ($menuList as $menu) {
                $menu = (array)$menu;
                $menu['menu_url'] = $this->_getMenuUrl($menu);
                if ($menu['father_id'] == $father_id) {
                    $nodes = $this->getMenuTree($menuList, $menu['id']);
                    $result[] = empty($nodes) ? $menu : array_merge($menu, ['nodes' => $nodes]);
                }
            }
        }

        return $result ?? '';
    }

    /**
     * @param array $menu
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

    public function currentUserMenu($allMenu, $currentUserPermission, $userId)
    {
        return Cache::tags(['user', $userId])->get('currentUserMenu') ?: $this->putCurrentUserMenuCache($allMenu, $currentUserPermission, $userId);
    }

    private function putCurrentUserMenuCache($allMenu, $currentUserPermission, $userId)
    {
        $currentUserMenu = array();
        foreach ($allMenu as $key => $menu){
            if ($menu['route_name'] == '#' || in_array($menu['route_name'], $currentUserPermission)){
                $currentUserMenu[] = $menu;
            }
        }

        Cache::tags(['user', $userId])->put('currentUserMenu', $currentUserMenu, 10);

        return $currentUserMenu;
    }

    private function putAllMenuCache()
    {
        $allMenu = Menu::all()->toArray();

        Cache::put('allMenus', $allMenu, 10);

        return $allMenu;
    }
}