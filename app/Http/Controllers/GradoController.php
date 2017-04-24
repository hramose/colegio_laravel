<?php

namespace App\Http\Controllers;

use App\App\Repositories\GradoRepo;
use App\App\Managers\GradoManager;
use App\App\Entities\Grado;
use Controller, Redirect, Input, View, Session, Variable;

class GradoController extends BaseController {

	protected $gradoRepo;

	public function __construct(GradoRepo $gradoRepo)
	{
		$this->gradoRepo = $gradoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$grados = $this->gradoRepo->all('numero');
		return view('administracion/grados/listado', compact('grados'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		$niveles = Variable::getNivelesAcademicos();
		return view('administracion/grados/agregar', compact('estados','niveles'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new GradoManager(new Grado(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el grado '.$data['descripcion'].' con éxito.');
		return redirect(route('grados'));
	}

	public function mostrarEditar($id)
	{
		$grado = $this->gradoRepo->find($id);
		$estados = Variable::getEstadosGenerales();
		$niveles = Variable::getNivelesAcademicos();
		return view('administracion/grados/editar', compact('grado','estados','niveles'));
	}

	public function editar($id)
	{
		$grado = $this->gradoRepo->find($id);
		$data = Input::all();
		$manager = new GradoManager($grado, $data);
		$manager->save();
		Session::flash('success', 'Se editó el grado '.$grado->descripcion.' con éxito.');
		return redirect(route('grados', $grado->liga_id));
	}


}