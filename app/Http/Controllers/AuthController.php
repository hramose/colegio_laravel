<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View;

class AuthController extends BaseController {

	public function __construct()
	{
		
	}

	public function mostrarLogin()
	{
		return view('administracion/login');
	}

	public function login()
	{
		$data = Input::only('username','password','remember_token');

		$credentials = [
			'username' => $data['username'],
			'password' => $data['password']
		];

		if(Auth::attempt($credentials))
		{
			return Redirect::route('dashboard');
		}
		
		return Redirect::back()->with('login-error',1);
	}

	public function mostrarDashboard()
	{
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
		return view('administracion/dashboard');
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route('login');
	}

}