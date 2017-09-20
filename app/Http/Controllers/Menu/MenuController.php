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
use App\Interfaces\RouteInfoInterface;
use App\Services\ValidatorService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
	/**
	 * @var MenuInterface
	 */
	protected $menu;

	/**
	 * @var ValidatorService
	 */
	protected $validator;

	/**
	 * @var RouteInfoInterface
	 */
	protected $routeInfo;

	/**
	 * MenuController constructor.
	 *
	 * @param MenuInterface      $menu
	 * @param ValidatorService   $validator
	 * @param RouteInfoInterface $routeInfo
	 */
	public function __construct(MenuInterface $menu, ValidatorService $validator, RouteInfoInterface $routeInfo)
	{
		$this->menu      = $menu;
		$this->validator = $validator;
		$this->routeInfo = $routeInfo;
	}

	/**
	 * 创建菜单验证规则
	 *
	 * @return array
	 */
	private function createMenuRules()
	{
		return [
			'menuState'   => 'required',
			'fatherMenu'  => 'required',
			'menuDisplay' => 'required',
			'routeName'   => 'required',
			'menuName'    => 'required',
			'menuSort'    => 'numeric',
			'icon'        => 'required',
		];
	}

	/**
	 * 验证失败后的返回信息
	 *
	 * @return array
	 */
	protected function errorInfo()
	{
		return [
			'menuState.required'   => '菜单位置不能为空',
			'fatherMenu.required'  => '上一级菜单不能为空',
			'menuDisplay.required' => '菜单显示状态不能为空',
			'routeName.required'   => '菜单URL不能为空',
			'menuName.required'    => '菜单名称不能为空',
			'menuSort.numeric'     => '排序必须为数值',
			'icon.required'        => '图标不能为空',
		];
	}

	/**
	 * 后台菜单管理页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function admin()
	{
		$allMenu       = $this->menu->allMenus();
		$data['menus'] = $this->menu->menuTree($allMenu);

		return view('menu.admin', $data);
	}

	/**
	 * 创建后台菜单页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createAdmin()
	{
		$allMenu        = $this->menu->allMenus();
		$data['menus']  = $this->menu->menuTree($allMenu);
		$data['routes'] = $this->routeInfo->allAdminRouteListByGet();

		return view('menu.createAdmin', $data);
	}

	/**
	 * 编辑指定后台菜单页面
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function editAdmin(Request $request)
	{
		$id = $request->input('id');

		$allMenu       = $this->menu->allMenus();
		$data['menu']  = $this->menu->findMenu($id);
		$data['menus'] = $this->menu->menuTree($allMenu);

		if (empty($data['menu'])) {
			return response()->json([
				'status'  => 500,
				'message' => '菜单不存在',
			]);
		}

		$data['routes'] = $this->routeInfo->allAdminRouteListByGet();

		return view('menu.editAdmin', $data);
	}

	/**
	 * 更新指定菜单
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request)
	{
		$validator = $this->validator->validate($request->all(), $this->createMenuRules(), $this->errorInfo());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		$menuData = $request->all();

		if ($menuData['id'] == $menuData['fatherMenu']) {
			return response()->json([
				'status'  => 500,
				'message' => '菜单不能和节点菜单相同',
			]);
		}

		$menu         = $this->menu->findMenu($menuData['id']);
		$menuChildren = $this->menu->menuCount(['father_id' => $menuData['id']]);

		if (empty($menu)) {
			return response()->json([
				'status'  => 500,
				'message' => '菜单不存在',
			]);
		} else {
			if ($menu->father_id != $menuData['fatherMenu'] && $menuChildren != 0) {
				return response()->json([
					'status'  => 500,
					'message' => '存在子菜单不能更改上级菜单',
				]);
			}
		}

		if (!$this->menu->updateMenu($menuData)) {
			return response()->json([
				'status'  => 500,
				'message' => '编辑失败',
			]);
		}

		return response()->json([
			'status'  => 200,
			'message' => '编辑成功',
		]);
	}

	/**
	 * 存储创建的菜单
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storage(Request $request)
	{
		$validator = $this->validator->validate($request->all(), $this->createMenuRules(), $this->errorInfo());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		$menuData = $request->all();

		if (!$this->menu->createMenu($menuData)) {
			return response()->json([
				'status'  => 500,
				'message' => '创建失败',
			]);
		}

		return response()->json([
			'status'  => 200,
			'message' => '创建成功',
		]);
	}

	/**
	 * 删除指定菜单
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request)
	{
		$id = $request->input('id');

		$menu         = $this->menu->findMenu($id);
		$menuChildren = $this->menu->menuCount(['father_id' => $id]);

		if (empty($menu)) {
			return response()->json([
				'status'  => 500,
				'message' => '菜单不存在',
			]);
		} else {
			if ($menuChildren != 0) {
				return response()->json([
					'status'  => 500,
					'message' => '存在子菜单不能删除',
				]);
			}
		}

		if (!$this->menu->deleteMenu($id)) {
			return response()->json([
				'status'  => 500,
				'message' => '删除失败',
			]);
		}

		return response()->json([
			'status'  => 200,
			'message' => '删除成功',
		]);
	}

	/**
	 * 菜单显示状态
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function display(Request $request)
	{
		$id      = $request->input('id');
		$display = $request->input('display');

		$menu = $this->menu->findMenu($id);
		if (empty($menu)) {
			return response()->json([
				'status'  => 500,
				'message' => '菜单不存在',
			]);
		}

		$menu->display = $display;

		$rs = $menu->save();

		if (!$rs) {
			return response()->json([
				'status'  => 500,
				'message' => '操作失败',
			]);
		}

		return response()->json([
			'status'  => 200,
			'message' => '操作成功',
		]);
	}
}