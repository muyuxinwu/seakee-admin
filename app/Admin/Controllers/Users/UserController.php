<?php
/**
 * File: UserController.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/30 14:48
 * Description:
 */

namespace App\Admin\Controllers\Users;


use App\Admin\Requests\Users\UserRequest;
use App\Http\Controllers\Controller;
use App\Services\Users\{AdminUserService, AdminRoleService};
use Illuminate\Http\Request;

class UserController extends Controller
{
	/**
	 * @var AdminUserService
	 */
	protected $userService;

	/**
	 * @var AdminRoleService
	 */
	protected $roleService;

	/**
	 * UserController constructor.
	 *
	 * @param AdminUserService $userService
	 * @param AdminRoleService $roleService
	 */
	public function __construct(AdminUserService $userService, AdminRoleService $roleService)
	{
		$this->userService = $userService;
		$this->roleService = $roleService;
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function index(Request $request)
	{
		return $this->userService->paginate($request);
	}

	/**
	 * @param UserRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(UserRequest $request)
	{
		$user = $this->userService->create($request);

		if (empty($user)){
			return response()->json(['error' => 'registration failed'], 500);
		}

		return response()->json(['msg' => 'success'],201);
	}

	/**
	 * @param string $id
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
	 */
	public function show(string $id)
	{
		return $this->userService->find($id);
	}

	/**
	 * @param string      $id
	 * @param UserRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(string $id, UserRequest $request)
	{
		$rs = $this->userService->edit($request, $id);

		if (empty($rs)){
			return response()->json(['error' => 'update failed'], 500);
		}

		clear_cache(['admin.permissions.' . $id, 'admin.roles.' . $id]);

		return response()->json(['msg' => 'success'],201);
	}

	/**
	 * @param string $ids
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(string $ids)
	{
		$rs = $this->userService->delete($ids);

		return $rs ? response()->json(['msg' => 'success'],204) : response()->json(['error' => 'failed'], 500);
	}

	/**
	 * @param string $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showRoles(string $id)
	{
		$user = $this->userService->find($id);

		if (empty($user)){
			return response()->json(['error' => 'not found'], 404);
		}

		return response()->json($user->roles);
	}

	/**
	 * @param string  $id
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function syncRoles(string $id, Request $request)
	{
		$roleIds = explode(",", $request->input('role_ids'));
		$user    = $this->userService->find($id);

		$this->roleService->find($roleIds);

		$rs = $user->roles()->sync($roleIds);

		if (empty($rs)){
			return response()->json(['error' => 'sync failed'], 500);
		}

		clear_cache(['admin.permissions.' . $id, 'admin.roles.' . $id]);

		return response()->json(['msg' => 'success'],201);
	}
}