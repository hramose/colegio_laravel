<?php

namespace App\Http\Controllers;

use App\App\Repositories\PlantillaUnidadRepo;
use App\App\Managers\PlantillaUnidadManager;
use App\App\Entities\PlantillaUnidad;
use Controller, Redirect, Input, View, Session, Variable;

class PlantillaUnidadController extends BaseController {

	protected $plantillaUnidadRepo;

	public function __construct(PlantillaUnidadRepo $plantillaUnidadRepo)
	{
		$this->plantillaUnidadRepo = $plantillaUnidadRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$plantillas = $this->plantillaUnidadRepo->all('descripcion');
		return view('administracion/plantillas_unidad/listado', compact('plantillas'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/plantillas_unidad/agregar', compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new PlantillaUnidadManager(new PlantillaUnidad(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la plantilla '.$data['descripcion'].' con éxito.');
		return redirect()->route('plantillas_unidad');
	}

	public function mostrarEditar($id)
	{
		$plantilla = $this->plantillaUnidadRepo->find($id);
		$estados = Variable::getEstadosGenerales();
		return view('administracion/plantillas_unidad/editar', compact('plantilla','estados'));
	}

	public function editar($id)
	{
		$plantilla = $this->plantillaUnidadRepo->find($id);
		$data = Input::all();
		$manager = new PlantillaUnidadManager($plantilla, $data);
		$manager->save();
		Session::flash('success', 'Se editó la plantilla '.$plantilla->descripcion.' con éxito.');
		return redirect()->route('plantillas_unidad');
	}


}