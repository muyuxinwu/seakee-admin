<?php

namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ], $this->errorInfo());
    }

    /**
     * Validation error info
     * @return array
     */
    protected function errorInfo()
    {
        return [
            'user_name.required' => '用户名不能为空',
            'user_name.max' => '用户名不能超过255位',
            'user_name.unique' => '用户名已存在',
            'email.required' => 'email不能为空',
            'email.max' => 'email不能超过255位',
            'email.unique' => 'email已存在',
            'email.email' => '请输入正确的email',
            'password.required' => '密码不能为空',
            'password.unique' => '密码不能少于6位',
            'password.confirmed' => '确认密码和密码不相符',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     * @param $request
     * @return User
     */
    protected function create($request)
    {
        $data = $request->all();
        $user = new User();

        $user->user_name = $data['user_name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);

        $user->save();

        $ipAddress = $request->getClientIp();
        $this->saveIP($user->id, $ipAddress, 1);

        return $user;
    }
}
