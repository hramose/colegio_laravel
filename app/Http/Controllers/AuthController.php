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
			$user->ciclo_id = null;
			$user->save();
			
			if($user->estado == 'I')
			{
				Session::flash('login-error','Usuario inactivo. Contacte a su administrador.');
				return Redirect::back();
			}

			/*$cicloRepo = new CicloRepo();
			$ciclo = $cicloRepo->getActual();
			
			$user->ciclo_id = $ciclo->id;
			$user->save();*/
			if($user->perfil_id == 1)
				return Redirect::route('dashboard');
			if($user->perfil_id == 2)
				return Redirect::route('dashboard');
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
		$estudiantes = $this->personaRepo->getByRolByEstado(['E'],['A']);
		$maestrosActivos = count($maestros);
		$estudiantesActivos = count($estudiantes);
		return view('administracion/dashboard',compact('maestrosActivos','estudiantesActivos'));
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
		if($user){
			$user->ciclo_id = null;
			$user->save();
		}
		Auth::logout();
		return Redirect::route('login');
	}

}