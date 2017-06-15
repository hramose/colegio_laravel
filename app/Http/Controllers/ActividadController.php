<?php

namespace App\Http\Controllers;

use App\App\Repositories\ActividadRepo;
use App\App\Managers\ActividadManager;
use App\App\Entities\Actividad;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\UnidadCurso;
use App\App\Repositories\UnidadCursoRepo;
use App\App\Repositories\TipoActividadRepo;

class ActividadController extends BaseController {

	protected $actividadRepo;
	protected $tipoActividadRepo;
	protected $unidadCursoRepo;

	public function __construct(ActividadRepo $actividadRepo, UnidadCursoRepo $unidadCursoRepo, TipoActividadRepo $tipoActividadRepo)
	{
		$this->actividadRepo = $actividadRepo;
		$this->tipoActividadRepo = $tipoActividadRepo;
		$this->unidadCursoRepo = $unidadCursoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(UnidadCurso $unidadCurso)
	{
		$actividades = $this->actividadRepo->getByUnidad($unidadCurso->id);
		$totalPorcentaje = 0;
		foreach($actividades as $actividad)
			$totalPorcentaje += $actividad->porcentaje;
		return view('administracion/actividades/listado', compact('actividades','unidadCurso','totalPorcentaje'));
	}

	public function mostrarAgregar(UnidadCurso $unidadCurso)
	{
		$tipos = $this->tipoActividadRepo->lists('descripcion','id');
		return view('administracion/actividades/agregar',compact('tipos','unidadCurso'));
	}

	public function agregar(UnidadCurso $unidadCurso)
	{
		$data = Input::all();
		$data['unidad_curso_id'] = $unidadCurso->id;
		$data['estado'] = 'A';
		$manager = new ActividadManager(new Actividad(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la actividad '.$data['titulo'].' con éxito.');
		return redirect()->route('actividades',$unidadCurso->id);
	}

	public function mostrarEditar(Actividad $actividad)
	{
		$tipos = $this->tipoActividadRepo->lists('descripcion','id');
		return view('administracion/actividades/editar', compact('actividad','tipos'));
	}

	public function editar(Actividad $actividad)
	{
		$data = Input::all();
		$data['unidad_curso_id'] = $actividad->unidad_curso_id;
		$data['estado'] = $actividad->estado;
		$data['actividad'] = $actividad->actividad;
		$manager = new ActividadManager($actividad, $data);
		$manager->save();
		Session::flash('success', 'Se editó la actividad '.$actividad->titulo.' con éxito.');
		return redirect()->route('actividades',$actividad->unidad_curso_id);
	}

}