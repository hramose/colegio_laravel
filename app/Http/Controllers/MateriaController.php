<?php

namespace App\Http\Controllers;

use App\App\Repositories\MateriaRepo;
use App\App\Managers\MateriaManager;
use App\App\Entities\Materia;
use Controller, Redirect, Input, View, Session, Variable;

class MateriaController extends BaseController {

	protected $materiaRepo;

	public function __construct(MateriaRepo $materiaRepo)
	{
		$this->materiaRepo = $materiaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$materias = $this->materiaRepo->all('descripcion');
		return view('administracion/materias/listado', compact('materias'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/materias/agregar', compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new MateriaManager(new Materia(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la materia '.$data['descripcion'].' con éxito.');
		return redirect(route('materias'));
	}

	public function mostrarEditar($id)
	{
		$materia = $this->materiaRepo->find($id);
		$estados = Variable::getEstadosGenerales();
		return view('administracion/materias/editar', compact('materia','estados'));
	}

	public function editar($id)
	{
		$materia = $this->materiaRepo->find($id);
		$data = Input::all();
		$manager = new MateriaManager($materia, $data);
		$manager->save();
		Session::flash('success', 'Se editó la materia '.$materia->descripcion.' con éxito.');
		return redirect(route('materias'));
	}


}