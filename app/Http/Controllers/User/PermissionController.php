<?php
/**
 * File: PermissionController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 15:04
 * Description:权限相关
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Interfaces\CacheInterface;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\RouteInfoInterface;
use App\Services\RequestParamsService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
	/**
	 * @var PermissionInterface
	 */
	protected $permission;

	/**
	 * @var ValidatorService
	 */
	protected $validator;

	/**
	 * @var RouteInfoInterface
	 */
	protected $routeInfo;

	/**
	 * @var RoleInterface
	 */
	protected $role;

	/**
	 * @var RequestParamsService
	 */
	protected $requestParams;

	/**
	 * @var CacheInterface
	 */
	protected $cache;

	/**
	 * Permission对应的数据库字段
	 */
	const permissionKeys = [
		'id',
		'name',
		'display_name',
		'description',
	];

	/**
	 * PermissionController constructor.
	 *
	 * @param RequestParamsService $requestParams
	 * @param PermissionInterface  $permission
	 * @param ValidatorService     $validator
	 * @param RouteInfoInterface   $routeInfo
	 * @param RoleInterface        $role
	 * @param CacheInterface       $cache
	 */
	public function __construct(RequestParamsService $requestParams, PermissionInterface $permission, ValidatorService $validator, RouteInfoInterface $routeInfo, RoleInterface $role, CacheInterface $cache)
	{
		$this->permission    = $permission;
		$this->validator     = $validator;
		$this->routeInfo     = $routeInfo;
		$this->role          = $role;
		$this->requestParams = $requestParams;
		$this->cache         = $cache;
	}

	/**
	 * 创建权限校验规则
	 *
	 * @return array
	 */
	protected function createRules()
	{
		return [
			'name'         => 'required|unique:permissions|max:30',
			'display_name' => 'required|max:30',
			'description'  => 'required|max:30',
		];
	}

	/**
	 * 编辑权限校验规则
	 *
	 * @param $id
	 *
	 * @return array
	 */
	protected function editRules($id)
	{
		return [
			'name'         => 'required|max:30|unique:permissions,name,' . $id,
			'display_name' => 'required|max:30',
			'description'  => 'required|max:30',
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
			'name.required'         => '权限标识不能为空',
			'name.unique'           => '已存在该权限',
			'name.max'              => '不能超过30个字符',
			'display_name.required' => '权限名称不能为空',
			'display_name.max'      => '不能超过30个字符',
			'description.required'  => '权限描述不能为空',
			'description.max'       => '不能超过30个字符',
		];
	}

	/**
	 * 权限管理页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$data['permissions'] = $this->permission->allWithPaginate(10);
		$data['routeList']   = $this->routeInfo->getRouteList();

		return view('user.permissionIndex', $data);
	}

	/**
	 * 权限存储
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request)
	{
		$permissionData = $this->requestParams->params(self::permissionKeys, $request);
		$validator      = $this->validator->firstError($permissionData, $this->createRules(), $this->validatorMessage());
		$isCustom       = $request->input('isCustom');
		$allRouteName   = $this->routeInfo->getAllRouteNameList();

		if (!empty($validator)) {
			return response()->json($validator);
		}

		if ($isCustom == 0 && !in_array($permissionData['name'], $allRouteName)) {
			return response()->json([
				'status'  => 500,
				'message' => '路由不存在',
			]);
		}

		if (!$this->permission->store($permissionData)) {
			return response()->json([
				'status'  => 500,
				'message' => '新增失败',
			]);
		}

		//清除权限缓存
		$this->cache->clearPermission();
		$this->cache->clearAllUserPermission();

		return response()->json([
			'status'  => 200,
			'message' => '新增成功',
		]);
	}

	/**
	 * 权限编辑
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request)
	{
		$permissionData = $this->requestParams->params(self::permissionKeys, $request);
		$validator      = $this->validator->firstError($permissionData, $this->editRules($permissionData['id']), $this->validatorMessage());
		$isCustom       = $request->input('isCustom');
		$allRouteName   = $this->routeInfo->getAllRouteNameList();

		if (!empty($validator)) {
			return response()->json($validator);
		}

		if ($isCustom == 0 && !in_array($permissionData['name'], $allRouteName)) {
			return response()->json([
				'status'  => 500,
				'message' => '路由不存在',
			]);
		}

		$permission = $this->permission->get($permissionData['id']);

		if (empty($permission)) {
			return response()->json([
				'status'  => 500,
				'message' => '权限不存在',
			]);
		}

		if (!$this->permission->update($permissionData)) {
			return response()->json([
				'status'  => 500,
				'message' => '编辑失败',
			]);
		}

		//清除权限缓存
		$this->cache->clearPermission();
		$this->cache->clearAllUserPermission();

		return response()->json([
			'status'  => 200,
			'message' => '编辑成功',
		]);
	}

	/**
	 * 返回Ajax权限编辑信息
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(Request $request)
	{
		$id = $request->input('id');

		if (empty($id)) {
			return response()->json([
				'status'  => 500,
				'message' => '请选择要编辑的权限',
			]);
		}

		$permission = $this->permission->get($id);

		if (empty($permission)) {
			return response()->json([
				'status'  => 500,
				'message' => '权限不存在',
			]);
		}

		return response()->json([
			'status'  => 200,
			'message' => 'success',
			'data'    => $permission,
		]);
	}

	/**
	 * 删除权限
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request)
	{
		$id = $request->input('id');

		if (empty($id)) {
			return response()->json([
				'status'  => 500,
				'message' => '请选择要删除的权限',
			]);
		}

		if (!$this->permission->delete($id)) {
			return response()->json([
				'status'  => 500,
				'message' => '删除失败',
			]);
		}

		//清除权限缓存
		$this->cache->clearPermission();
		$this->cache->clearAllUserPermission();

		return response()->json([
			'status'  => 200,
			'message' => '删除成功',
		]);
	}

	/**
	 * 角色权限页面
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function rolePermission(Request $request)
	{
		$roleID = $request->input('roleID');
		$role   = $this->role->get($roleID);

		if (empty($role)) {
			return response()->json([
				'status'  => 500,
				'message' => '角色不存在',
			]);
		}

		$rolePermission           = $role->perms()->get()->toArray();
		$data['permissions']      = $this->permission->all()->toArray();
		$data['rolePermissionID'] = array_column($rolePermission, 'id');
		$data['role']             = $role->toArray();

		return view('user.authorization', $data);
	}

	/**
	 * 角色授权
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function authorization(Request $request)
	{
		$permissionID = $request->input('permissionID');
		$roleID       = $request->input('roleID');

		$role = $this->role->get($roleID);

		if (empty($role)) {
			return response()->json([
				'status'  => 500,
				'message' => '角色不存在',
			]);
		}

		$permission = explode(",", $permissionID);

		if (empty($permission[0])) {
			return response()->json([
				'status'  => 500,
				'message' => '请指定权限',
			]);
		}

		$role->perms()->sync($permission, true);

		$this->cache->clearPermission();
		$this->cache->clearAllUserPermission();

		return response()->json([
			'status'  => 200,
			'message' => 'success',
		]);
	}

	/**
	 * 批量创建权限
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function batchCreate()
	{
		$allRouteName      = $this->routeInfo->getAllAdminRouteNameList();
		$allPermissionName = $this->permission->allName();

		$blankPermissions = [];
		foreach ($allRouteName as $name) {
			if (!in_array($name, $allPermissionName)) {
				$blankPermissions[] = $name;
			}
		}

		if (empty($blankPermissions)) {
			return response()->json([
				'status'  => 500,
				'message' => '没有需要添加的权限',
			]);
		}

		$length  = count($blankPermissions);
		$failure = 0;
		foreach ($blankPermissions as $key => $permission) {
			$permissionData['name']         = $permission;
			$permissionData['display_name'] = $permission;
			$permissionData['description']  = $permission;
			if (!$this->permission->store($permissionData)) {
				$failure += 1;
			}
		}

		//清除权限缓存
		$this->cache->clearPermission();
		$this->cache->clearAllUserPermission();

		return response()->json([
			'status'  => 200,
			'message' => '共新增' . $length . '条权限，其中成功' . ($length - $failure) . '条失败' . $failure . '条',
		]);
	}
}