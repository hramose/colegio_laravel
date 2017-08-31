<?php

namespace App\Http\Controllers;

use App\App\Repositories\UsuarioRepo;
use App\App\Managers\UsuarioManager;
use App\App\Entities\User;

use App\App\Repositories\PerfilRepo;
use App\App\Repositories\PersonaRepo;

use Controller, Redirect, Input, View, Session;

class UsuarioController extends BaseController {

	protected $usuarioRepo;
	protected $perfilRepo;
	protected $personaRepo;

	public function __construct(UsuarioRepo $usuarioRepo, PerfilRepo $perfilRepo, PersonaRepo $personaRepo)
	{
		$this->usuarioRepo = $usuarioRepo;
		$this->perfilRepo = $perfilRepo;
		$this->personaRepo = $personaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$usuarios = $this->usuarioRepo->all('username');
		return view('administracion/usuarios/listado', compact('usuarios'));
	}

	public function mostrarAgregar()
	{
		$perfiles = $this->perfilRepo->lists('descripcion','id');
		$personas = $this->personaRepo->getWithNoUser()->pluck('nombre_completo','id')->toArray();
		return view('administracion/usuarios/agregar',compact('perfiles','personas'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new UsuarioManager(new User(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el usuario '.$data['username'].' con éxito.');
		return redirect()->route('usuarios');
	}

	public function resetPassword($id)
	{
		$usuario = $this->usuarioRepo->find($id);
		if(\Gate::allows('edit_super_admin',$usuario))
		{			
			$data = Input::all();
			$manager = new UsuarioManager($usuario, $data);
			$manager->resetPassword();
			Session::flash('success', 'Se cambió la contraseña del usuario '.$usuario->username.' con éxito.');
			return redirect()->route('usuarios');
		}
		Session::flash('error', 'Usted no es superadmin. No tiene permisos para realizar esta acción.');
		return redirect()->route('usuarios');
	}

	public function inactivarUsuario($id)
	{
		$usuario = $this->usuarioRepo->find($id);
		if(\Gate::allows('is_super_admin'))
		{			
			$data = Input::all();
			$manager = new UsuarioManager($usuario, $data);
			$manager->inactivar();
			Session::flash('success', 'Se inactivó el usuario '.$usuario->username.' con éxito.');
			return redirect()->route('usuarios');
		}
		Session::flash('error', 'Usted no es superadmin. No tiene permisos para realizar esta acción.');
		return redirect()->route('usuarios');
	}

	public function activarUsuario($id)
	{
		$usuario = $this->usuarioRepo->find($id);
		if(\Gate::allows('is_super_admin'))
		{			
			$data = Input::all();
			$manager = new UsuarioManager($usuario, $data);
			$manager->activar();
			Session::flash('success', 'Se activó el usuario '.$usuario->username.' con éxito.');
			return redirect()->route('usuarios');
		}
		Session::flash('error', 'Usted no es superadmin. No tiene permisos para realizar esta acción.');
		return redirect()->route('usuarios');
	}


}