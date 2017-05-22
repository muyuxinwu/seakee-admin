<?php
/**
 * File: UserControllers.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 14:53
 * Description:
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * UserController constructor.
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * registration rules
     * @return array
     */
    protected function registrationRules()
    {
        return [
            'user_name' => 'required|max:255|unique:users',
            'nick_name' => 'max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'regex:/^1[34578][0-9]{9}$/',
            'password' => 'required|min:6|confirmed',
        ];
    }

    /**
     * Validation error info
     * @return array
     */
    protected function errorInfo()
    {
        return [
            /**
             * registration
             */
            'user_name.required' => '用户名不能为空',
            'user_name.max' => '用户名不能超过255位',
            'user_name.unique' => '用户名已存在',
            'email.required' => 'email不能为空',
            'email.max' => 'email不能超过255位',
            'email.unique' => 'email已存在',
            'email.email' => '请输入正确的email',
            'password.required' => '密码不能为空',
            'password.min' => '密码不能少于6位',
            'password.confirmed' => '确认密码和密码不相符',
            'nick_name.unique' => '昵称已存在',
            'nick_name.max' => '昵称不能超过255位',
            'phone.regex' => '手机号错误',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    protected function editRules($id)
    {
        return [
            'user_name' => 'required|max:255|unique:users,user_name,' . $id,
            'nick_name' => 'max:255|unique:users,nick_name,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'regex:/^1[34578][0-9]{9}$/',
            'password' => 'confirmed',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->allUserWithPaginate(10);
        return view('user.userIndex', [
            'users' => $users,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminCreateUser()
    {
        return view('user.createUser');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        $validator = $this->validator($request->all(), $this->registrationRules());
        $validator = $this->getValidatorMsg($validator);

        if (!empty($validator)) {
            return response()->json($validator);
        }

        $userData = $request->all();

        if (!$this->user->createUser($userData)) {
            return response()->json(['status' => 500, 'message' => '新增失败']);
        }

        return response()->json(['status' => 200, 'message' => '新增成功']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $user = $this->user->findUser($id);
        if (empty($user)) {
            return response()->json(['status' => 500, 'message' => '用户不存在']);
        }

        $user->status = $status;

        $rs = $user->save();

        if (!$rs) {
            return response()->json(['status' => 500, 'message' => '操作失败']);
        }

        return response()->json(['status' => 200, 'message' => '操作成功']);
    }

    /**
     * return edit user page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function adminEditUser(Request $request)
    {
        $id = $request->input('id');

        if (empty($id)) {
            return response()->json(['status' => 500, 'message' => '请选择要编辑的用户']);
        }

        $user = $this->user->findUser($id);

        if (empty($user)) {
            return response()->json(['status' => 500, 'message' => '用户不存在']);
        }

        return view('user.editUser', ['user' => $user]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editUser(Request $request)
    {
        $validator = $this->validator($request->all(), $this->editRules($request->input('id')));
        $validator = $this->getValidatorMsg($validator);

        if (!empty($validator)) {
            return response()->json($validator);
        }

        $userData = $request->all();

        if (empty($userData['id'])) {
            return response()->json(['status' => 500, 'message' => '请选择要编辑的用户']);
        }

        $menu = $this->user->findUser($userData['id']);

        if (empty($menu)) {
            return response()->json(['status' => 500, 'message' => '用户不存在']);
        }

        if (!$this->user->updateUser($userData)) {
            return response()->json(['status' => 500, 'message' => '编辑失败']);
        }

        return response()->json(['status' => 200, 'message' => '编辑成功']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request)
    {
        $id = $request->input('id');

        if (empty($id)) {
            return response()->json(['status' => 500, 'message' => '请选择要删除的用户']);
        }

        $user = $this->user->findUser($id);

        if (empty($user)) {
            return response()->json(['status' => 500, 'message' => '用户不存在']);
        }

        if (!$this->user->deleteUser($id)) {
            return response()->json(['status' => 500, 'message' => '删除失败']);
        }

        return response()->json(['status' => 200, 'message' => '删除成功']);
    }
}