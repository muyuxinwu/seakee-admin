<?php

namespace App\Http\Middleware;

use Closure;
use Request;

class CheckApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if ($_SERVER['SERVER_NAME'] != $request->getHttpHost()){
		    //ajax请求直接返回json
		    if (Request::ajax()) {
			    return response()->json([
				    'status'  => 500,
				    'message' => '权限不足，请联系管理员',
			    ]);
		    }

		    //返回session('error');到原页面
		    return back()->withInput()->withError('no_permissions');
	    }

        return $next($request);
    }
}
