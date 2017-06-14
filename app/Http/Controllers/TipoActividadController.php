<?php

namespace App\Http\Controllers;

use Variable;

use App\App\Repositories\TipoActividadRepo;
use App\App\Managers\TipoActividadManager;
use App\App\Entities\TipoActividad;
use Controller, Redirect, Input, View, Session;

class TipoActividadController extends BaseController {

	protected $tipoActividadRepo;

	public function __construct(TipoActividadRepo $tipoActividadRepo)
	{
		$this->tipoActividadRepo = $tipoActividadRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$tipos = $this->tipoActividadRepo->all('descripcion');
		return view('administracion/tipos_actividades/listado', compact('tipos'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/tipos_actividades/agregar',compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new TipoActividadManager(new TipoActividad(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el tipo de actividad '.$data['descripcion'].' con éxito.');
		return redirect()->route('tipos_actividades');
	}

	public function mostrarEditar($id)
	{
		$estados = Variable::getEstadosGenerales();
		$tipoActividad = $this->tipoActividadRepo->find($id);
		return view('administracion/tipos_actividades/editar', compact('tipoActividad','estados'));
	}

	public function editar($id)
	{
		$tipoActividad = $this->tipoActividadRepo->find($id);
		$data = Input::all();
		$manager = new TipoActividadManager($tipoActividad, $data);
		$manager->save();
		Session::flash('success', 'Se editó el tipo de actividad '.$tipoActividad->descripcion.' con éxito.');
		return redirect()->route('tipos_actividades');
	}


}