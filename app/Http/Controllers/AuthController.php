<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View, Session;

use App\App\Repositories\PersonaRepo;
use App\App\Repositories\CicloRepo;

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
			$user = Auth::user();
			
			if($user->estado == 'I')
			{
				Session::flash('login-error','Usuario inactivo. Contacte a su administrador.');
				return Redirect::back();
			}


			/*$cicloRepo = new CicloRepo();
			$ciclo = $cicloRepo->getActual();
			
			$user->ciclo_id = $ciclo->id;
			$user->save();*/

			if($user->perfil_id == 3)
				return Redirect::route('maestros.dashboard');
			if($user->perfil_id == 4)
				return Redirect::route('estudiantes.dashboard');
			
			return Redirect::route('dashboard');

			
		}
		Session::flash('login-error','Credenciales no válidas.');
		return Redirect::back();
	}

	public function mostrarDashboard()
	{
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');

		$maestros = $this->personaRepo->getByRolByEstado(['M'],['A']);
		$maestrosActivos = count($maestros);
		return view('administracion/dashboard',compact('maestrosActivos'));
	}

	public function mostrarMaestros()
	{
		View::composer('layouts.maestros','App\Http\Controllers\MaestroMenuController');

		$maestro = $this->personaRepo->getByRolByEstado(['M'],['A']);
		$maestrosActivos = count($maestros);
		return view('administracion/dashboard',compact('maestrosActivos'));
	}

	public function logout()
	{
		$user = Auth::user();
		$user->ciclo_id = null;
		$user->save();
		Auth::logout();
		return Redirect::route('login');
	}

}