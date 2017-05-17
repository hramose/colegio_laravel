<?php

namespace App\Http\Controllers;

use Variable;

use App\App\Repositories\PerfilRepo;
use App\App\Managers\PerfilManager;
use App\App\Entities\Perfil;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\GrupoPerfilRepo;

class PerfilController extends BaseController {

	protected $perfilRepo;

	public function __construct(PerfilRepo $perfilRepo)
	{
		$this->perfilRepo = $perfilRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$perfiles = $this->perfilRepo->all('descripcion');
		return view('administracion/perfiles/listado', compact('perfiles'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/perfiles/agregar',compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new PerfilManager(new Perfil(), $data);
		$manager->save();
		return redirect()->route('perfiles');
	}

	public function mostrarEditar($id)
	{
		$estados = Variable::getEstadosGenerales();
		$perfil = $this->perfilRepo->find($id);
		return view('administracion/perfiles/editar', compact('perfil','estados'));
	}

	public function editar($id)
	{
		$perfil = $this->perfilRepo->find($id);
		$data = Input::all();
		$manager = new PerfilManager($perfil, $data);
		$manager->save();
		Session::flash('success', 'Se editó el perfil de usuario con éxito.');
		return redirect()->route('perfiles');
	}


}