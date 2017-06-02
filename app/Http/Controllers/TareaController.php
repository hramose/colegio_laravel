<?php

namespace App\Http\Controllers;

use App\App\Repositories\TareaRepo;
use App\App\Managers\TareaManager;
use App\App\Entities\Tarea;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Unidad;
use App\App\Repositories\UnidadRepo;
use App\App\Repositories\TipoTareaRepo;

class TareaController extends BaseController {

	protected $tareaRepo;
	protected $tipoTareaRepo;
	protected $unidadRepo;

	public function __construct(TareaRepo $tareaRepo, UnidadRepo $unidadRepo, TipoTareaRepo $tipoTareaRepo)
	{
		$this->tareaRepo = $tareaRepo;
		$this->tipoTareaRepo = $tipoTareaRepo;
		$this->unidadRepo = $unidadRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Unidad $unidad)
	{
		$tareas = $this->tareaRepo->getByUnidad($unidad->id);
		$totalPorcentaje = 0;
		foreach($tareas as $tarea)
			$totalPorcentaje += $tarea->porcentaje;
		return view('administracion/tareas/listado', compact('tareas','unidad','totalPorcentaje'));
	}

	public function mostrarAgregar(Unidad $unidad)
	{
		$tipos = $this->tipoTareaRepo->lists('descripcion','id');
		return view('administracion/tareas/agregar',compact('tipos','unidad'));
	}

	public function agregar(Unidad $unidad)
	{
		$data = Input::all();
		$data['unidad_id'] = $unidad->id;
		$data['estado'] = 'A';
		$manager = new TareaManager(new Tarea(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la tarea '.$data['titulo'].' con éxito.');
		return redirect()->route('tareas',$unidad->id);
	}

	public function mostrarEditar(Tarea $tarea)
	{
		$tipos = $this->tipoTareaRepo->lists('descripcion','id');
		return view('administracion/tareas/editar', compact('tarea','tipos'));
	}

	public function editar(Tarea $tarea)
	{
		$data = Input::all();
		$data['unidad_id'] = $tarea->unidad_id;
		$data['estado'] = $tarea->estado;
		$data['tarea'] = $tarea->tarea;
		$manager = new TareaManager($tarea, $data);
		$manager->save();
		Session::flash('success', 'Se editó la tarea '.$tarea->titulo.' con éxito.');
		return redirect()->route('tareas',$tarea->unidad_id);
	}


}