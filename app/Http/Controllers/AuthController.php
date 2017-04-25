<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View;

use App\App\Repositories\PersonaRepo;

class AuthController extends BaseController {

	protected $personaRepo;

	public function __construct(PersonaRepo $personaRepo)
	{
		$this->personaRepo = $personaRepo;
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

		$maestros = $this->personaRepo->getByRolByEstado(['M'],['A']);
		$maestrosActivos = count($maestros);
		return view('administracion/dashboard',compact('maestrosActivos'));
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route('login');
	}

}