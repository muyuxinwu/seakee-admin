<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Ip\Ip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get a validator for an incoming request.
     *
     * @param  array $data
     * @param  array $rules
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, array $rules)
    {
        return Validator::make($data, $rules, $this->errorInfo());
    }

    /**
     * get Validator Message
     * @param $validator
     * @return array|null
     */
    protected function getValidatorMsg($validator)
    {
        if ($validator->fails()) {
            $messages = $validator->messages()->setFormat('');

            foreach ($messages->getMessages() as $k => $v) {
                $error = [$v[0]];
                return ['status' => 500, 'message' => $error];
            }
        }

        return NULL;
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

            /**
             * create menu
             */
            'menuState.required' => '菜单位置不能为空',
            'fatherMenu.required' => '上一级菜单不能为空',
            'menuDisplay.required' => '菜单显示状态不能为空',
            'menuURL.required' => '菜单URL不能为空',
            'menuName.required' => '菜单名称不能为空',
            'menuSort.numeric' => '排序必须为数值',
        ];
    }
    
    /**
     * return logged user
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser()
    {
        if (Auth::check()) {
            $user = Auth::user();
        }

        return $user ?? '';
    }

    /**
     * save IP
     * @param $userID
     * @param $ipAddress
     * @param int $state
     * @return bool
     */
    protected function saveIP($userID, $ipAddress, $state = 2)
    {
        $ip = new Ip();

        $ip->user_id = $userID;
        $ip->state = $state;
        $ip->ip = $ipAddress;

        return $ip->save();
    }

    /**
     * get all of routes
     * @return mixed
     */
    protected function getRoute()
    {
        $route = Route::getRoutes()->getRoutesByMethod();
        return $route;
    }
}
