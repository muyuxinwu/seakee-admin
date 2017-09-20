<?php
/**
 * File: RoleController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 15:03
 * Description:
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
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

	protected $user;

	/**
	 * RoleController constructor.
	 *
	 * @param RoleInterface    $role
	 * @param ValidatorService $validator
	 * @param UserInterface    $user
	 */
	public function __construct(RoleInterface $role, ValidatorService $validator, UserInterface $user)
	{
		$this->role      = $role;
		$this->validator = $validator;
		$this->user      = $user;
	}

	/**
	 * @return array
	 */
	protected function createRoleRules()
	{
		return ['name' => 'required|unique:roles|max:30', 'display_name' => 'required|max:30', 'description' => 'required|max:30',];
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	protected function editRoleRules($id)
	{
		return ['name' => 'required|max:30|unique:roles,name,' . $id, 'display_name' => 'required|max:30', 'description' => 'required|max:30',];
	}

	/**
	 * Validation error info
	 * @return array
	 */
	protected function errorInfo()
	{
		return ['name.required' => '角色标识不能为空', 'name.unique' => '已存在该角色', 'name.max' => '不能超过30个字符', 'display_name.required' => '角色名称不能为空', 'display_name.max' => '不能超过30个字符', 'description.required' => '角色描述不能为空', 'description.max' => '不能超过30个字符',];
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$roles = $this->role->allRoleWithPaginate(10);

		return view('user.roleIndex', ['roles' => $roles]);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createRole(Request $request)
	{
		$validator = $this->validator->validate($request->all(), $this->createRoleRules(), $this->errorInfo());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		$roleData = $request->all();

		if (!$this->role->createRole($roleData)) {
			return response()->json(['status' => 500, 'message' => '新增失败']);
		}

		return response()->json(['status' => 200, 'message' => '新增成功']);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function editRole(Request $request)
	{
		$validator = $this->validator->validate($request->all(), $this->editRoleRules($request->input('id')), $this->errorInfo());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		$roleData = $request->all();

		if (empty($roleData['id'])) {
			return response()->json(['status' => 500, 'message' => '请选择要编辑的角色']);
		}

		$role = $this->role->findRole($roleData['id']);

		if (empty($role)) {
			return response()->json(['status' => 500, 'message' => '角色不存在']);
		}

		if (!$this->role->updateRole($roleData)) {
			return response()->json(['status' => 500, 'message' => '编辑失败']);
		}

		return response()->json(['status' => 200, 'message' => '编辑成功']);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showEditInfo(Request $request)
	{
		$id = $request->input('id');

		if (empty($id)) {
			return response()->json(['status' => 500, 'message' => '请选择要编辑的角色']);
		}

		$role = $this->role->findRole($id);

		if (empty($role)) {
			return response()->json(['status' => 500, 'message' => '角色不存在']);
		}

		return response()->json(['status' => 200, 'message' => 'success', 'data' => $role]);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteRole(Request $request)
	{
		$id = $request->input('id');

		if (empty($id)) {
			return response()->json(['status' => 500, 'message' => '请选择要删除的角色']);
		}

		$role = $this->role->findRole($id);

		if (empty($role)) {
			return response()->json(['status' => 500, 'message' => '角色不存在']);
		}

		if (!$this->role->deleteRole($id)) {
			return response()->json(['status' => 500, 'message' => '删除失败']);
		}

		return response()->json(['status' => 200, 'message' => '删除成功']);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getUserRoleList(Request $request)
	{
		$userID = $request->input('userID');
		$user   = $this->user->findUser($userID);

		if (empty($user)) {
			return response()->json(['status' => 500, 'message' => '用户不存在']);
		}

		$userRole           = $user->roles()->getResults()->toArray();
		$data['roles']      = $this->role->allRole()->toArray();
		$data['userRoleID'] = array_column($userRole, 'id');
		$data['user']       = $user->toArray();

		return view('user.assignRole', $data);
	}

	/**
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
			return response()->json(['status' => 500, 'message' => '用户不存在']);
		}

		$roles = explode(",", $rolesID);

		if (empty($roles[0])) {
			return response()->json(['status' => 500, 'message' => '请指定角色']);
		}

		$user->roles()->sync($roles, true);

		return response()->json(['status' => 200, 'message' => 'success']);
	}
}