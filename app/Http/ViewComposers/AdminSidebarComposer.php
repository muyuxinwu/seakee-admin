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
use Illuminate\Support\Facades\Cache;
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
        //$currentUserPermission = $this->getCurrentUserPermission();
        $view->with('sidebarMenu', $this->menu->menuTree());
    }

    /**
     * 获取当前用户权限
     *
     * @return mixed
     */
    private function getCurrentUserPermission()
    {
        $currentUserPermission = Cache::get('currentUserPermission');
        if (empty($currentUserPermission)) {
            $user = session('user');
            $currentUserRole = $this->role->currentUserRole($user->id);
            $currentUserPermission = $this->permission->currentUserPermission($currentUserRole);

            Cache::put('currentUserPermission', $currentUserPermission, 10);
        }

        return $currentUserPermission;
    }
}