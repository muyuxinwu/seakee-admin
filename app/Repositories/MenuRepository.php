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

class MenuRepository implements MenuInterface
{
    public function allMenus()
    {
        return Menu::all()->toArray();
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
        $menu->menu_url = $data['menuURL'];
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
        $menu->menu_url = $data['menuURL'];
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
}