<?php

namespace App\Http\Controllers;

use App\App\Repositories\DetallePlantillaUnidadRepo;
use App\App\Managers\DetallePlantillaUnidadManager;
use App\App\Entities\DetallePlantillaUnidad;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\PlantillaUnidadRepo;
use App\App\Entities\PlantillaUnidad;

class DetallePlantillaUnidadController extends BaseController {

	protected $detallePlantillaUnidadRepo;

	public function __construct(DetallePlantillaUnidadRepo $detallePlantillaUnidadRepo)
	{
		$this->detallePlantillaUnidadRepo = $detallePlantillaUnidadRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(PlantillaUnidad $plantillaUnidad)
	{
		$unidades = $this->detallePlantillaUnidadRepo->getByPlantilla($plantillaUnidad->id);
		$totalPorcentaje = 0;
		foreach($unidades as $unidad)
			$totalPorcentaje += $unidad->porcentaje;
		return view('administracion/detalle_plantilla_unidad/listado', compact('unidades','plantillaUnidad','totalPorcentaje'));
	}

	public function mostrarAgregar(PlantillaUnidad $plantillaUnidad)
	{
		$unidades = Variable::getUnidades();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/detalle_plantilla_unidad/agregar', compact('estados','plantillaUnidad','unidades'));
	}

	public function agregar(PlantillaUnidad $plantillaUnidad)
	{
		$data = Input::all();
		$data['plantilla_unidad_id'] = $plantillaUnidad->id;
		$data['estado'] = 'A';
		$unidades = $plantillaUnidad->unidades;
		$manager = new DetallePlantillaUnidadManager(new DetallePlantillaUnidad(), $data);
		$manager->agregar($unidades);
		Session::flash('success', 'Se agregó la unidad a la plantilla con éxito.');
		return redirect()->route('detalle_plantilla_unidad',$plantillaUnidad->id);
	}

	public function mostrarEditar($id)
	{
		$unidad = $this->detallePlantillaUnidadRepo->find($id);
		return view('administracion/detalle_plantilla_unidad/editar', compact('unidad'));
	}

	public function editar($id)
	{
		$unidad = $this->detallePlantillaUnidadRepo->find($id);
		$data = Input::all();
		$data['plantilla_unidad_id'] = $unidad->plantilla_unidad_id;
		$data['unidad'] = $unidad->unidad;
		$data['estado'] = $unidad->estado;
		$unidades = $unidad->plantilla_unidad->unidades;
		$manager = new DetallePlantillaUnidadManager($unidad, $data);
		$manager->agregar($unidades);
		Session::flash('success', 'Se editó la unidad de la plantilla con éxito.');
		return redirect()->route('detalle_plantilla_unidad',$unidad->plantilla_unidad_id);
	}


}