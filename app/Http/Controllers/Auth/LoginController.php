<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\CacheInterface;
use App\Interfaces\IpInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Cache;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use RedirectsUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * @var IpInterface
	 */
	protected $ip;

	protected $cache;

	/**
	 * LoginController constructor.
	 *
	 * @param IpInterface    $ip
	 * @param CacheInterface $cache
	 */
	public function __construct(IpInterface $ip, CacheInterface $cache)
	{
		$this->middleware('guest', ['except' => 'logout']);
		$this->ip    = $ip;
		$this->cache = $cache;
	}

	/**
	 * Show the application's login form.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showLoginForm(Request $request)
	{
		//登录前请求URL
		$data['previousUrl'] = $request->session()->previousUrl();

		return view('auth.login', $data);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		if ($this->attemptLogin($request)) {
			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return void
	 */
	protected function validateLogin(Request $request)
	{
		$this->validate($request, [$this->username() => 'required|string', 'password' => 'required|string',]);
	}

	/**
	 * Attempt to log the user into the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return bool
	 */
	protected function attemptLogin(Request $request)
	{
		return $this->guard()->attempt($this->credentials($request), $request->has('remember'));
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		$login      = $request->input($this->username());
		$loginField = $this->loginField($login);

		$credentials[$loginField] = $login;
		$credentials['password']  = $request->input('password');

		return $credentials;
	}

	/**
	 * Get the login field
	 *
	 * @param $login
	 *
	 * @return string
	 */
	protected function loginField($login)
	{
		if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
			return 'email';
		}

		if (is_phone_number($login)) {
			return 'phone';
		}

		return 'user_name';
	}
	/**
	 * Send the response after the user was authenticated.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();

		//登录前请求URL
		$previousUrl = $request->get('previousUrl') ?: $this->redirectTo;

		$this->clearLoginAttempts($request);

		return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($previousUrl);
	}

	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  mixed                    $user
	 *
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		$ipAddress = $request->getClientIp();
		$request->session()->put('user', $user);
		$this->ip->storageIP($user->id, $ipAddress, 2);
		view()->share('user', $user);
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendFailedLoginResponse(Request $request)
	{
		$errors = [$this->username() => trans('auth.failed')];

		if ($request->expectsJson()) {
			return response()->json($errors, 422);
		}

		return redirect()->back()->withInput($request->only($this->username(), 'remember'))->withErrors($errors);
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return 'login';
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->clearCache($request->user()->id);

		$this->guard()->logout();

		$request->session()->flush();

		$request->session()->regenerate();

		return redirect('/');
	}

	/**
	 * Get the guard to be used during authentication.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return Auth::guard();
	}

	/**
	 * Clear all caches of current logon user
	 *
	 * @param $userId
	 */
	protected function clearCache($userId)
	{
		$this->cache->clearUserRole($userId);
		$this->cache->clearUserPermission($userId);
		$this->cache->clearUserMenu($userId);
	}
}
