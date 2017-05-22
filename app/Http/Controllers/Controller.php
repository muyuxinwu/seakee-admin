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
