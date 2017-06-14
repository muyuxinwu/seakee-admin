<?php

namespace App\Http\Controllers\Auth;

use App\Interfaces\IpInterface;
use App\Interfaces\UserInterface;
use App\Models\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Validator;

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
     * registration rules
     * @return array
     */
    protected function registrationRules()
    {
        return [
            'user_name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

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
        Validator::make($request->all(), $this->registrationRules())->validate();

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
     * @var IpInterface
     */
    protected $ip;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * RegisterController constructor.
     * @param IpInterface $ip
     * @param UserInterface $user
     */
    public function __construct(IpInterface $ip, UserInterface $user)
    {
        $this->middleware('guest');
        $this->ip = $ip;
        $this->user = $user;
    }

    /**
     * Create a new user instance after a valid registration.
     * @param $request
     * @return User
     */
    protected function create($request)
    {
        $user = $this->user->createUser($request->all());

        $ipAddress = $request->getClientIp();
        $this->ip->storageIP($user->id, $ipAddress, 1);

        return $user;
    }
}
