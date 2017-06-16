<?php

namespace App\Http\Controllers;

use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Managers\EstudianteSeccionManager;
use App\App\Entities\EstudianteSeccion;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\SeccionRepo;
use App\App\Repositories\PersonaRepo;
use App\App\Repositories\MateriaRepo;
use App\App\Repositories\ActividadRepo;
use App\App\Entities\Seccion;

class EstudianteSeccionController extends BaseController {

	protected $estudianteSeccionRepo;
	protected $seccionRepo;
	protected $personaRepo;
	protected $actividadRepo;

	public function __construct(EstudianteSeccionRepo $estudianteSeccionRepo, SeccionRepo $seccionRepo, PersonaRepo $personaRepo, ActividadRepo $actividadRepo)
	{
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;
		$this->seccionRepo = $seccionRepo;
		$this->personaRepo = $personaRepo;
		$this->actividadRepo = $actividadRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Seccion $seccion)
	{
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		return view('administracion/estudiantes_seccion/listado', compact('estudiantes','seccion'));
	}

	public function mostrarAgregar(Seccion $seccion)
	{
		$estudiantes = $this->personaRepo->getNotInCicloByRolByEstado($seccion->ciclo_id, ['E'], ['A']);
		return view('administracion/estudiantes_seccion/agregar', compact('seccion','estudiantes'));
	}

	public function agregar(Seccion $seccion)
	{
		$data = Input::all();
		$actividades = $this->actividadRepo->getBySeccion($seccion->id);
		$manager = new EstudianteSeccionManager(null, $data);
		$manager->agregarEstudiantes($seccion, $actividades);
		Session::flash('success', 'Se agregaron los estudiantes a '.$seccion->grado->descripcion .' '.$seccion->descripcion_seccion.' con éxito.');
		return redirect()->route('estudiantes_seccion',$seccion->id);
	}

	public function mostrarEditar($id)
	{
		$estudianteSeccion = $this->estudianteSeccionRepo->find($id);
		return view('administracion/estudiantes_seccion/editar', compact('estudianteSeccion'));
	}

	public function editar($id)
	{
		$estudianteSeccion = $this->estudianteSeccionRepo->find($id);
		$data = Input::all();
		$data['estudiante_id'] = $estudianteSeccion->estudiante_id;
		$data['seccion_id'] = $estudianteSeccion->seccion_id;
		$data['estado'] = $estudianteSeccion->estado;
		$manager = new EstudianteSeccionManager($estudianteSeccion, $data);
		$manager->save();
		Session::flash('success', 'Se editó el estudiante '.$estudianteSeccion->estudiante->nombre_completo.' de '.$estudianteSeccion->seccion->grado->descripcion.' '.$estudianteSeccion->seccion->descripcion_seccion.' con éxito.');
		return redirect()->route('estudiantes_seccion', $seccion->id);
	}

	public function corregirCodigos(Seccion $seccion)
	{
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		$manager = new EstudianteSeccionManager(null, null);
		$manager->corregirCodigos($estudiantes);
		Session::flash('success', 'Se corrigieron los codigos de los estudiantes de '.$seccion->grado->descripcion .' '.$seccion->descripcion_seccion.' con éxito.');
		return redirect()->route('estudiantes_seccion',$seccion->id);
	}


}
