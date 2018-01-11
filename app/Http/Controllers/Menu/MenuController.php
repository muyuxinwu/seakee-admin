<?php
/**
 * File: MenuController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 12:58
 * Description:菜单相关
 */

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Interfaces\CacheInterface;
use App\Interfaces\MenuInterface;
use App\Interfaces\RouteInfoInterface;
use App\Services\RequestParamsService;
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
	 * @var RequestParamsService
	 */
	protected $requestParams;

	/**
	 * @var CacheInterface
	 */
	protected $cache;

	/**
	 * menu对应的数据库字段
	 */
	const MENU_KEYS = [
		'id',
		'icon',
		'menu_name',
		'route_name',
		'father_id',
		'sort',
		'display',
		'state',
		'is_custom',
	];

	/**
	 * MenuController constructor.
	 *
	 * @param MenuInterface        $menu
	 * @param ValidatorService     $validator
	 * @param RouteInfoInterface   $routeInfo
	 * @param RequestParamsService $requestParams
	 * @param CacheInterface       $cache
	 */
	public function __construct(MenuInterface $menu, ValidatorService $validator, RouteInfoInterface $routeInfo, RequestParamsService $requestParams, CacheInterface $cache)
	{
		$this->menu          = $menu;
		$this->validator     = $validator;
		$this->routeInfo     = $routeInfo;
		$this->requestParams = $requestParams;
		$this->cache         = $cache;
	}

	/**
	 * 创建菜单验证规则
	 *
	 * @return array
	 */
	private function createRules()
	{
		return [
			'state'      => 'required',
			'father_id'  => 'required',
			'display'    => 'required',
			'route_name' => 'required',
			'menu_name'  => 'required',
			'sort'       => 'numeric',
			'icon'       => 'required',
		];
	}

	/**
	 * 验证失败后的返回信息
	 *
	 * @return array
	 */
	protected function validatorMessage()
	{
		return [
			'state.required'      => '菜单位置不能为空',
			'father_id.required'  => '上一级菜单不能为空',
			'display.required'    => '菜单显示状态不能为空',
			'route_name.required' => '菜单URL不能为空',
			'menu_name.required'  => '菜单名称不能为空',
			'sort.numeric'        => '排序必须为数值',
			'icon.required'       => '图标不能为空',
		];
	}

	/**
	 * 后台菜单管理页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function admin()
	{
		$allMenu       = $this->menu->allWithoutCache();
		$data['menus'] = $this->menu->tree($allMenu);

		return view('menu.admin', $data);
	}

	/**
	 * 创建后台菜单页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createAdmin()
	{
		$allMenu        = $this->menu->allWithoutCache();
		$data['menus']  = $this->menu->tree($allMenu);
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

		$allMenu       = $this->menu->allWithoutCache();
		$data['menu']  = $this->menu->get($id);
		$data['menus'] = $this->menu->tree($allMenu);

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
		$menuData = $this->requestParams->params(self::MENU_KEYS, $request);

		$validator = $this->validator->firstError($menuData, $this->createRules(), $this->validatorMessage());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		if ($menuData['id'] == $menuData['father_id']) {
			return response()->json([
				'status'  => 500,
				'message' => '菜单不能和节点菜单相同',
			]);
		}

		$menu         = $this->menu->get($menuData['id']);
		$menuChildren = $this->menu->count(['father_id' => $menuData['id']]);

		if ($menu->father_id != $menuData['father_id'] && $menuChildren != 0) {
			return response()->json([
				'status'  => 500,
				'message' => '存在子菜单不能更改上级菜单',
			]);
		}

		if (!$this->menu->update($menuData)) {
			return response()->json([
				'status'  => 500,
				'message' => '编辑失败',
			]);
		}

		//清除菜单缓存
		$this->cache->clearMenu();
		$this->cache->clearAllUserMenu();

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
	public function store(Request $request)
	{
		$params = $this->requestParams->params(self::MENU_KEYS, $request);

		$validator = $this->validator->firstError($params, $this->createRules(), $this->validatorMessage());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		if (!$this->menu->store($params)) {
			return response()->json([
				'status'  => 500,
				'message' => '创建失败',
			]);
		}

		//清除菜单缓存
		$this->cache->clearMenu();
		$this->cache->clearAllUserMenu();

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

		$menuChildren = $this->menu->count(['father_id' => $id]);

		if ($menuChildren != 0) {
			return response()->json([
				'status'  => 500,
				'message' => '存在子菜单不能删除',
			]);
		}

		if (!$this->menu->delete($id)) {
			return response()->json([
				'status'  => 500,
				'message' => '删除失败',
			]);
		}

		//清除菜单缓存
		$this->cache->clearMenu();
		$this->cache->clearAllUserMenu();

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
		$params = $this->requestParams->params(self::MENU_KEYS, $request);

		$menu = $this->menu->get($params['id']);
		if (empty($menu)) {
			return response()->json([
				'status'  => 500,
				'message' => '菜单不存在',
			]);
		}

		if (!$this->menu->update($params)) {
			return response()->json([
				'status'  => 500,
				'message' => '操作失败',
			]);
		}

		//清除菜单缓存
		$this->cache->clearMenu();
		$this->cache->clearAllUserMenu();

		return response()->json([
			'status'  => 200,
			'message' => '操作成功',
		]);
	}
}