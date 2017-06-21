<?php
/**
 * File: PermissionController.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 15:04
 * Description:
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\RouteInfoInterface;
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
     * PermissionController constructor.
     * @param PermissionInterface $permission
     * @param ValidatorService $validator
     * @param RouteInfoInterface $routeInfo
     * @param RoleInterface $role
     */
    public function __construct(PermissionInterface $permission,
                                ValidatorService $validator,
                                RouteInfoInterface $routeInfo,
                                RoleInterface $role)
    {
        $this->permission = $permission;
        $this->validator = $validator;
        $this->routeInfo = $routeInfo;
        $this->role = $role;
    }

    /**
     * @return array
     */
    protected function createPermissionRules()
    {
        return [
            'name' => 'required|unique:permissions|max:30',
            'display_name' => 'required|max:30',
            'description' => 'required|max:30',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    protected function editPermissionRules($id)
    {
        return [
            'name' => 'required|max:30|unique:permissions,name,' . $id,
            'display_name' => 'required|max:30',
            'description' => 'required|max:30',
        ];
    }

    /**
     * Validation error info
     * @return array
     */
    protected function errorInfo()
    {
        return [
            'name.required' => '权限标识不能为空',
            'name.unique' => '已存在该权限',
            'name.max' => '不能超过30个字符',
            'display_name.required' => '权限名称不能为空',
            'display_name.max' => '不能超过30个字符',
            'description.required' => '权限描述不能为空',
            'description.max' => '不能超过30个字符',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['permissions'] = $this->permission->allPermissionWithPaginate(10);
        $data['routeList'] = $this->routeInfo->getRouteList();
        return view('user.permissionIndex', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPermission(Request $request)
    {
        $validator = $this->validator->validate($request->all(), $this->createPermissionRules(), $this->errorInfo());

        if (!empty($validator)) {
            return response()->json($validator);
        }

        $permissionData = $request->all();

        if (!in_array($permissionData['name'], $this->routeInfo->getAllRouteNameList())) {
            return response()->json(['status' => 500, 'message' => '路由不存在']);
        }

        if (!$this->permission->createPermission($permissionData)) {
            return response()->json(['status' => 500, 'message' => '新增失败']);
        }

        return response()->json(['status' => 200, 'message' => '新增成功']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editPermission(Request $request)
    {
        $validator = $this->validator->validate($request->all(), $this->editPermissionRules($request->input('id')), $this->errorInfo());

        if (!empty($validator)) {
            return response()->json($validator);
        }

        $permissionData = $request->all();

        if (!in_array($permissionData['name'], $this->routeInfo->getAllRouteNameList())) {
            return response()->json(['status' => 500, 'message' => '路由不存在']);
        }

        if (empty($permissionData['id'])) {
            return response()->json(['status' => 500, 'message' => '请选择要编辑的权限']);
        }

        $permission = $this->permission->findPermission($permissionData['id']);

        if (empty($permission)) {
            return response()->json(['status' => 500, 'message' => '权限不存在']);
        }

        if (!$this->permission->updatePermission($permissionData)) {
            return response()->json(['status' => 500, 'message' => '编辑失败']);
        }

        return response()->json(['status' => 200, 'message' => '编辑成功']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showEditInfo(Request $request)
    {
        $id = $request->input('id');

        if (empty($id)) {
            return response()->json(['status' => 500, 'message' => '请选择要编辑的权限']);
        }

        $permission = $this->permission->findPermission($id);

        if (empty($permission)) {
            return response()->json(['status' => 500, 'message' => '权限不存在']);
        }

        return response()->json(['status' => 200, 'message' => 'success', 'data' => $permission]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePermission(Request $request)
    {
        $id = $request->input('id');

        if (empty($id)) {
            return response()->json(['status' => 500, 'message' => '请选择要删除的权限']);
        }

        $permission = $this->permission->findPermission($id);

        if (empty($permission)) {
            return response()->json(['status' => 500, 'message' => '权限不存在']);
        }

        if (!$this->permission->deletePermission($id)) {
            return response()->json(['status' => 500, 'message' => '删除失败']);
        }

        return response()->json(['status' => 200, 'message' => '删除成功']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getRolePermissionList(Request $request)
    {
        $roleID = $request->input('roleID');
        $role = $this->role->findRole($roleID);

        if (empty($role)) {
            return response()->json(['status' => 500, 'message' => '角色不存在']);
        }

        $rolePermission = $role->perms()->get()->toArray();
        $data['permissions'] = $this->permission->allPermission()->toArray();
        $data['rolePermissionID'] = array_column($rolePermission, 'id');
        $data['role'] = $role->toArray();

        return view('user.authorization', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authorization(Request $request)
    {
        $permissionID = $request->input('permissionID');
        $roleID = $request->input('roleID');

        $role = $this->role->findRole($roleID);

        if (empty($role)) {
            return response()->json(['status' => 500, 'message' => '角色不存在']);
        }

        $permission = explode(",", $permissionID);

        if (empty($permission[0])) {
            return response()->json(['status' => 500, 'message' => '请指定权限']);
        }

        $role->perms()->sync($permission, true);

        return response()->json(['status' => 200, 'message' => 'success']);
    }
}