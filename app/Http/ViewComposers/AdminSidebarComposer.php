<?php
/**
 * File: AdminSidebarComposer.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/16 17:14
 * Description:
 */

namespace App\Http\ViewComposers;


use App\Interfaces\MenuInterface;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use Illuminate\View\View;

class AdminSidebarComposer
{
    /**
     * @var MenuInterface
     */
    private $menu;

    /**
     * @var RoleInterface
     */
    private $role;

    /**
     * @var PermissionInterface
     */
    private $permission;

    /**
     * AdminSidebarComposer constructor.
     *
     * @param MenuInterface $menu
     * @param RoleInterface $role
     * @param PermissionInterface $permission
     */
    public function __construct(MenuInterface $menu, RoleInterface $role, PermissionInterface $permission)
    {
        $this->menu = $menu;
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('sidebarMenu', $this->getCurrentUserMenu());
    }

    private function getCurrentUserMenu()
    {
        $userId = session('user')->id;
        $roleId = $this->role->currentUserRole($userId);
        $allMenu = $this->menu->allMenus();
        $allPermissionName = $this->permission->allPermissionName();
        $currentUserPermission = $this->permission->currentUserPermission($roleId, $userId, $allPermissionName);

        $currentUserMenu = $this->menu->currentUserMenu($allMenu, $currentUserPermission, $userId);

        return $this->menu->menuTree($currentUserMenu);
    }
}