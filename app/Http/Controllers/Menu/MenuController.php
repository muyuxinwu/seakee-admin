<?php
/**
 * File: MenuController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 12:58
 * Description:
 */

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Interfaces\MenuInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * @var MenuInterface
     */
    private $menu;

    /**
     * MenuController constructor.
     * @param MenuInterface $menu
     */
    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
    }

    /**
     * create Menu Rules
     * @return array
     */
    private function createMenuRules()
    {
        return [
            'menuState' => 'required',
            'fatherMenu' => 'required',
            'menuDisplay' => 'required',
            'menuURL' => 'required',
            'menuName' => 'required',
            'menuSort' => 'numeric',
        ];
    }

    /**
     * return admin menu manage page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin()
    {
        $menus = $this->menu->menuTree();

        return view('menu.admin', ['menus' => $menus]);
    }

    /**
     * return create admin menu page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createAdminMenu()
    {
        $menus = $this->menu->menuTree();

        $route = $this->getRoute();

        foreach ($route['GET'] as $key => $value) {
            if (stripos($key, 'admin/') !== false) {
                $routes[] = $key;
            }
        }

        return view('menu.createAdmin', [
            'routes' => $routes ?? '',
            'menus' => $menus,
        ]);
    }

    /**
     * return edit admin menu page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function editAdminMenu(Request $request)
    {
        $id = $request->input('id');

        if (empty($id)) {
            return response()->json(['status' => 500, 'message' => '请选择要删除的菜单']);
        }

        $menu = $this->menu->findMenu($id);
        $menus = $this->menu->menuTree();

        if (empty($menu)) {
            return response()->json(['status' => 500, 'message' => '菜单不存在']);
        }

        $route = $this->getRoute();

        foreach ($route['GET'] as $key => $value) {
            if (stripos($key, 'admin/') !== false) {
                $routes[] = $key;
            }
        }

        return view('menu.editAdmin', [
            'routes' => $routes ?? '',
            'menu' => $menu,
            'menus' => $menus,
        ]);
    }

    /**
     * to edit a menu
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editMenu(Request $request)
    {
        $validator = $this->validator($request->all(), $this->createMenuRules());
        $validator = $this->getValidatorMsg($validator);

        if (!empty($validator)) {
            return response()->json($validator);
        }

        $menuData = $request->all();

        if (empty($menuData['id'])) {
            return response()->json(['status' => 500, 'message' => '请选择要编辑的菜单']);
        }

        if ($menuData['id'] == $menuData['fatherMenu']) {
            return response()->json(['status' => 500, 'message' => '菜单不能和节点菜单相同']);
        }

        $menu = $this->menu->findMenu($menuData['id']);
        $menuChildren = $this->menu->menuCount(['father_id' => $menuData['id']]);

        if (empty($menu)) {
            return response()->json(['status' => 500, 'message' => '菜单不存在']);
        } else {
            if ($menu->father_id != $menuData['fatherMenu'] && $menuChildren != 0) {
                return response()->json(['status' => 500, 'message' => '存在子菜单不能更改上级菜单']);
            }
        }

        if (!$this->menu->updateMenu($menuData)) {
            return response()->json(['status' => 500, 'message' => '编辑失败']);
        }

        return response()->json(['status' => 200, 'message' => '编辑成功']);
    }

    /**
     * create a menu
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMenu(Request $request)
    {
        $validator = $this->validator($request->all(), $this->createMenuRules());
        $validator = $this->getValidatorMsg($validator);

        if (!empty($validator)) {
            return response()->json($validator);
        }

        $menuData = $request->all();

        if (!$this->menu->createMenu($menuData)) {
            return response()->json(['status' => 500, 'message' => '创建失败']);
        }

        return response()->json(['status' => 200, 'message' => '创建成功']);
    }

    /**
     * to delete a menu
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMenu(Request $request)
    {
        $id = $request->input('id');

        if (empty($id)) {
            return response()->json(['status' => 500, 'message' => '请选择要删除的菜单']);
        }

        $menu = $this->menu->findMenu($id);
        $menuChildren = $this->menu->menuCount(['father_id' => $id]);

        if (empty($menu)) {
            return response()->json(['status' => 500, 'message' => '菜单不存在']);
        } else {
            if ($menuChildren != 0) {
                return response()->json(['status' => 500, 'message' => '存在子菜单不能删除']);
            }
        }

        if (!$this->menu->deleteMenu($id)) {
            return response()->json(['status' => 500, 'message' => '删除失败']);
        }

        return response()->json(['status' => 200, 'message' => '删除成功']);
    }

    /**
     * to change the display status of a menu
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeDisplay(Request $request)
    {
        $id = $request->input('id');
        $display = $request->input('display');

        $menu = $this->menu->findMenu($id);
        if (empty($menu)) {
            return response()->json(['status' => 500, 'message' => '菜单不存在']);
        }

        $menu->display = $display;

        $rs = $menu->save();

        if (!$rs) {
            return response()->json(['status' => 500, 'message' => '操作失败']);
        }

        return response()->json(['status' => 200, 'message' => '操作成功']);
    }
}