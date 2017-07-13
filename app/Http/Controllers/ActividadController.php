<?php

namespace App\Http\Controllers;

use App\App\Repositories\ActividadRepo;
use App\App\Managers\ActividadManager;
use App\App\Entities\Actividad;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\UnidadCurso;
use App\App\Repositories\UnidadCursoRepo;
use App\App\Repositories\TipoActividadRepo;

use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Entities\ActividadEstudiante;
use App\App\Managers\ActividadEstudianteManager;

class ActividadController extends BaseController {

	protected $actividadRepo;
	protected $tipoActividadRepo;
	protected $unidadCursoRepo;
	protected $actividadEstudianteRepo;

	public function __construct(ActividadRepo $actividadRepo, UnidadCursoRepo $unidadCursoRepo, TipoActividadRepo $tipoActividadRepo,ActividadEstudianteRepo $actividadEstudianteRepo)
	{
		$this->actividadRepo = $actividadRepo;
		$this->tipoActividadRepo = $tipoActividadRepo;
		$this->unidadCursoRepo = $unidadCursoRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
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
		return redirect()->route('unidades_curso',$unidadCurso->curso_id);
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
		return redirect()->route('unidades_curso',$actividad->unidad_curso->curso_id);
	}

	public function mostrarVerNotas(Actividad $actividad)
	{
		$actividades = $this->actividadEstudianteRepo->getByActividad($actividad->id);	
		return view('maestros/ver_notas_actividad', compact('actividad','actividades'));
	}

	public function mostrarCalificarActividades(Actividad $actividad)
	{
		$actividades = $this->actividadEstudianteRepo->getByActividad($actividad->id);	
		return view('administracion/actividades/calificar_actividades', compact('actividad','actividades'));
	}

	public function calificarActividades(Actividad $actividad)
	{
		$data = Input::all();
		$manager = new ActividadEstudianteManager(null, $data);
		$manager->calificarActividades($actividad);
		Session::flash('success', 'Se calificaron las actividades de '.$actividad->titulo.' con éxito.');
		return redirect()->route('ver_notas_actividad',$actividad->id);
	}

	public function mostrarCalificarActividad(ActividadEstudiante $actividad)
	{
		return view('administracion/actividades/calificar_actividad', compact('actividad'));
	}

	public function calificarActividad(ActividadEstudiante $actividad)
	{
		$data = Input::all();
		$data['actividad_id'] = $actividad->actividad_id;
		$data['estudiante_id'] = $actividad->estudiante_id;
		$data['estado'] = 'C';
		$manager = new ActividadEstudianteManager($actividad, $data);
		$manager->save();
		Session::flash('success', 'Se calificó la actividad de '.$actividad->actividad->titulo.' de '.$actividad->estudiante->nombre_completo.' con éxito.');
		return redirect()->route('ver_notas_actividad',$actividad->actividad_id);
	}

}