<?php
/**
 * File: AdminSidebarComposer.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/16 17:14
 * Description:
 */

namespace App\Http\ViewComposers;


use App\Interfaces\MenuInterface;
use Illuminate\View\View;

class AdminSidebarComposer
{
    /**
     * @var MenuInterface
     */
    private $menu;

    /**
     * AdminSidebarComposer constructor.
     * @param MenuInterface $menu
     */
    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('sidebarMenu', $this->menu->menuTree());
    }
}