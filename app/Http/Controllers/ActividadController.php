<?php

namespace App\Http\Controllers;

use App\App\Repositories\ActividadRepo;
use App\App\Managers\ActividadManager;
use App\App\Entities\Actividad;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Unidad;
use App\App\Repositories\UnidadRepo;
use App\App\Repositories\TipoActividadRepo;

class ActividadController extends BaseController {

	protected $actividadRepo;
	protected $tipoActividadRepo;
	protected $unidadRepo;

	public function __construct(ActividadRepo $actividadRepo, UnidadRepo $unidadRepo, TipoActividadRepo $tipoActividadRepo)
	{
		$this->actividadRepo = $actividadRepo;
		$this->tipoActividadRepo = $tipoActividadRepo;
		$this->unidadRepo = $unidadRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Unidad $unidad)
	{
		$actividades = $this->actividadRepo->getByUnidad($unidad->id);
		$totalPorcentaje = 0;
		foreach($actividades as $actividad)
			$totalPorcentaje += $actividad->porcentaje;
		return view('administracion/actividades/listado', compact('actividades','unidad','totalPorcentaje'));
	}

	public function mostrarAgregar(Unidad $unidad)
	{
		$tipos = $this->tipoActividadRepo->lists('descripcion','id');
		return view('administracion/actividades/agregar',compact('tipos','unidad'));
	}

	public function agregar(Unidad $unidad)
	{
		$data = Input::all();
		$data['unidad_id'] = $unidad->id;
		$data['estado'] = 'A';
		$manager = new ActividadManager(new Actividad(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la actividad '.$data['titulo'].' con éxito.');
		return redirect()->route('actividades',$unidad->id);
	}

	public function mostrarEditar(Actividad $actividad)
	{
		$tipos = $this->tipoActividadRepo->lists('descripcion','id');
		return view('administracion/actividades/editar', compact('actividad','tipos'));
	}

	public function editar(Actividad $actividad)
	{
		$data = Input::all();
		$data['unidad_id'] = $actividad->unidad_id;
		$data['estado'] = $actividad->estado;
		$data['actividad'] = $actividad->actividad;
		$manager = new ActividadManager($actividad, $data);
		$manager->save();
		Session::flash('success', 'Se editó la actividad '.$actividad->titulo.' con éxito.');
		return redirect()->route('actividades',$actividad->unidad_id);
	}

}