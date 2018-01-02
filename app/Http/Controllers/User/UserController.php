<?php
/**
 * File: UserControllers.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/5/8 14:53
 * Description:用户相关
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use App\Services\RequestParamsService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;

class UserController extends Controller
{
	/**
	 * @var UserInterface
	 */
	protected $user;

	/**
	 * @var ValidatorService
	 */
	protected $validator;

	/**
	 * @var RequestParamsService
	 */
	protected $requestParams;

	/**
	 * User对应的数据库字段
	 */
	const userKeys = [
		'id',
		'user_name',
		'nick_name',
		'avatar',
		'email',
		'phone',
		'status',
		'rank',
		'password',
		'password_confirmation',
	];

	/**
	 * UserController constructor.
	 *
	 * @param RequestParamsService $requestParams
	 * @param UserInterface        $user
	 * @param ValidatorService     $validator
	 */
	public function __construct(RequestParamsService $requestParams, UserInterface $user, ValidatorService $validator)
	{
		$this->user          = $user;
		$this->validator     = $validator;
		$this->requestParams = $requestParams;
	}

	/**
	 * 注册验证规则
	 *
	 * @return array
	 */
	protected function registrationRules()
	{
		return [
			'user_name' => 'required|max:255|unique:users',
			'nick_name' => 'max:255|unique:users',
			'email'     => 'required|email|max:255|unique:users',
			'phone'     => 'regex:/^1[34578][0-9]{9}$/|unique:users',
			'password'  => 'required|min:6|confirmed',
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
			'user_name.required' => '用户名不能为空',
			'user_name.max'      => '用户名不能超过255位',
			'user_name.unique'   => '用户名已存在',
			'email.required'     => 'email不能为空',
			'email.max'          => 'email不能超过255位',
			'email.unique'       => 'email已存在',
			'email.email'        => '请输入正确的email',
			'password.required'  => '密码不能为空',
			'password.min'       => '密码不能少于6位',
			'password.confirmed' => '确认密码和密码不相符',
			'nick_name.unique'   => '昵称已存在',
			'nick_name.max'      => '昵称不能超过255位',
			'phone.regex'        => '手机号错误',
			'phone.unique'   => '手机号已存在',
		];
	}

	/**
	 * 编辑规则
	 *
	 * @param $id
	 *
	 * @return array
	 */
	protected function editRules($id)
	{
		return [
			'user_name' => 'required|max:255|unique:users,user_name,' . $id,
			'nick_name' => 'max:255|unique:users,nick_name,' . $id,
			'email'     => 'required|email|max:255|unique:users,email,' . $id,
			'phone'     => 'regex:/^1[34578][0-9]{9}$/',
			'password'  => 'confirmed',
		];
	}

	/**
	 * 用户管理首页
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$data['users'] = $this->user->allWithPaginate(10);

		return view('user.userIndex', $data);
	}

	/**
	 * 后台添加用户页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function adminCreate()
	{
		return view('user.createUser');
	}

	/**
	 * 保存用户
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request)
	{
		$userData  = $this->requestParams->params(self::userKeys, $request);
		$validator = $this->validator->firstError($userData, $this->registrationRules(), $this->validatorMessage());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		if (!$this->user->storageUser($userData)) {
			return response()->json([
				'status'  => 500,
				'message' => '新增失败',
			]);
		}

		return response()->json([
			'status'  => 200,
			'message' => '新增成功',
		]);
	}

	/**
	 * 修改用户状态
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function status(Request $request)
	{
		$userData = $this->requestParams->params(self::userKeys, $request);

		if (!$this->user->update($userData)) {
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

	/**
	 * 用户编辑页面
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function adminEdit(Request $request)
	{
		$id           = $request->input('id');
		$data['user'] = $this->user->get($id);

		return view('user.editUser', $data);
	}

	/**
	 * 更新用户信息
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request)
	{
		$userData  = $this->requestParams->params(self::userKeys, $request);
		$validator = $this->validator->firstError($userData, $this->editRules($request->input('id')), $this->validatorMessage());

		if (!empty($validator)) {
			return response()->json($validator);
		}

		if (!$this->user->update($userData)) {
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
	 * 删除用户
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request)
	{
		$id   = $request->input('id');

		if (!$this->user->delete($id)) {
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
}