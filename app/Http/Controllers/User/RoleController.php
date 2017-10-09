<?php
/**
 * File: RoleController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 15:03
 * Description:
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Interfaces\CacheInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Services\RequestParamsService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	/**
	 * @var RoleInterface
	 */
	protected $role;

	/**
	 * @var ValidatorService
	 */
	protected $validator;

	/**
	 * @var UserInterface
	 */
	protected $user;

	/**
	 * @var RequestParamsService
	 */
	protected $requestParams;

	/**
	 * @var CacheInterface
	 */
	protected $cache;

	/**
	 * Role对应的数据库字段
	 */
	const roleKeys = [
		'id',
		'name',
		'display_name',
		'description',
	];

	/**
	 * RoleController constructor.
	 *
	 * @param RequestParamsService $requestParams
	 * @param RoleInterface        $role
	 * @param ValidatorService     $validator
	 * @param UserInterface        $user
	 */
	public function __construct(RequestParamsService $requestParams, RoleInterface $role, ValidatorService $validator, UserInterface $user, CacheInterface $cache)
	{
		$this->role          = $role;
		$this->validator     = $validator;
		$this->user          = $user;
		$this->requestParams = $requestParams;
		$this->cache         = $cache;
	}

	/**
	 * 创建角色校验规则
	 *
	 * @return array
	 */
	protected function createRules()
	{
		return [
			'name'         => 'required|unique:roles|max:30',
			'display_name' => 'required|max:30',
			'description'  => 'required|max:30',
		];
	}

	/**
	 * 编辑角色校验规则
	 *
	 * @param $id
	 *
	 * @return array
	 */
	protected function editRules($id)
	{
		return [
			'name'         => 'required|max:30|unique:roles,name,' . $id,
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
			'name.required'         => '角色标识不能为空',
			'name.unique'           => '已存在该角色',
			'name.max'              => '不能超过30个字符',
			'display_name.required' => '角色名称不能为空',
			'display_name.max'      => '不能超过30个字符',
			'description.required'  => '角色描述不能为空',
			'description.max'       => '不能超过30个字符',
		];
	}

	/**
	 * 角色管理页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$data['roles'] = $this->role->allRoleWithPaginate(10);

		return view('user.roleIndex', $data);
	}

	/**
	 * 保存角色
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storage(Request $request)
	{
		$roleData  = $this->requestParams->params(self::roleKeys, $request);
		$validator = $this->validator->firstError($roleData, $this->createRules(), $this->validatorMessage());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		if (!$this->role->createRole($roleData)) {
			return response()->json([
				'status'  => 500,
				'message' => '新增失败',
			]);
		}

		$this->cache->clearAllUserRole();

		return response()->json([
			'status'  => 200,
			'message' => '新增成功',
		]);
	}

	/**
	 * 更新角色
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request)
	{
		$roleData  = $this->requestParams->params(self::roleKeys, $request);
		$validator = $this->validator->firstError($roleData, $this->editRules($request->input('id')), $this->validatorMessage());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		$role = $this->role->findRole($roleData['id']);

		if (empty($role)) {
			return response()->json([
				'status'  => 500,
				'message' => '角色不存在',
			]);
		}

		if (!$this->role->updateRole($roleData)) {
			return response()->json([
				'status'  => 500,
				'message' => '编辑失败',
			]);
		}

		$this->cache->clearAllUserRole();

		return response()->json([
			'status'  => 200,
			'message' => '编辑成功',
		]);
	}

	/**
	 * 返回Ajax角色编辑信息
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(Request $request)
	{
		$id = $request->input('id');

		$role = $this->role->findRole($id);

		if (empty($role)) {
			return response()->json([
				'status'  => 500,
				'message' => '角色不存在',
			]);
		}

		return response()->json([
			'status'  => 200,
			'message' => 'success',
			'data'    => $role,
		]);
	}

	/**
	 * 删除角色
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request)
	{
		$id = $request->input('id');

		$role = $this->role->findRole($id);

		if (empty($role)) {
			return response()->json([
				'status'  => 500,
				'message' => '角色不存在',
			]);
		}

		if (!$this->role->deleteRole($id)) {
			return response()->json([
				'status'  => 500,
				'message' => '删除失败',
			]);
		}

		$this->cache->clearAllUserRole();

		return response()->json([
			'status'  => 200,
			'message' => '删除成功',
		]);
	}

	/**
	 * 用户角色页面
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function userRole(Request $request)
	{
		$userID = $request->input('userID');
		$user   = $this->user->findUser($userID);

		if (empty($user)) {
			return response()->json([
				'status'  => 500,
				'message' => '用户不存在',
			]);
		}

		$userRole           = $user->roles()->getResults()->toArray();
		$data['roles']      = $this->role->allRole()->toArray();
		$data['userRoleID'] = array_column($userRole, 'id');
		$data['user']       = $user->toArray();

		return view('user.assignRole', $data);
	}

	/**
	 * 角色分配
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function assignRole(Request $request)
	{
		$userID  = $request->input('userID');
		$rolesID = $request->input('rolesID');

		$user = $this->user->findUser($userID);

		if (empty($user)) {
			return response()->json([
				'status'  => 500,
				'message' => '用户不存在',
			]);
		}

		$roles = explode(",", $rolesID);

		if (empty($roles[0])) {
			return response()->json([
				'status'  => 500,
				'message' => '请指定角色',
			]);
		}

		$user->roles()->sync($roles, true);

		$this->cache->clearUserRole($userID);

		return response()->json([
			'status'  => 200,
			'message' => 'success',
		]);
	}
}