<?php namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Admin\AdminController;
use App\Models\Admin;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;


class AuthController extends AdminController {

	private $loginPath = '/admin';
	private $redirectPath = '/admin/dashboard';

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}


	public function getLogin()
	{
		return view('admin/auth/login');
	}


	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath);
		}

		return redirect($this->loginPath)
			->withInput($request->only('email', 'remember'))
			->withErrors([
				'email' => 'These credentials do not match our records.',
			]);
	}

	public function getLogout()
	{
		$this->auth->logout();

		return redirect('admin/');
	}
}
