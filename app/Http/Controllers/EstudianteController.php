<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, Variable, Excel, PDF;

use App\App\Repositories\CicloRepo;
use App\App\Repositories\SeccionRepo;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Repositories\ActividadRepo;
use App\App\Repositories\ActividadEstudianteRepo;

use App\App\Entities\Seccion;
use App\App\Entities\Curso;
use App\App\Entities\EstudianteSeccion;
use App\App\Entities\Actividad;

class EstudianteController extends BaseController {

	protected $cicloRepo;
	protected $seccionRepo;
	protected $cursoRepo;
	protected $estudianteSeccionRepo;
	protected $actividadRepo;
	protected $actividadEstudianteRepo;

	public function __construct(CicloRepo $cicloRepo, SeccionRepo $seccionRepo, CursoRepo $cursoRepo, EstudianteSeccionRepo $estudianteSeccionRepo, ActividadRepo $actividadRepo, ActividadEstudianteRepo $actividadEstudianteRepo)
	{
		$this->cicloRepo = $cicloRepo;
		$this->seccionRepo = $seccionRepo;
		$this->cursoRepo = $cursoRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;
		$this->actividadRepo = $actividadRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function dashboard()
	{
		$ciclo = \Auth::user()->ciclo;
		$estudiante = \Auth::user()->persona;
		$seccion = $this->estudianteSeccionRepo->getByCicloByEstudiante($ciclo->id, $estudiante->id);
		if(is_null($seccion)){
			Session::flash('error', $estudiante->nombre_completo . ', no estás asignado a ninguna sección en el ciclo ' . $ciclo->descripcion);
		}
		$seccion = $seccion->seccion;
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		$cantidadEstudiantes = count($seccion->estudiantes);
		return view('estudiantes/dashboard', compact('seccion','cursos', 'cantidadEstudiantes'));
	}

	public function verCurso(Curso $curso)
	{
		$estudiante = \Auth::user()->persona;
		$unidades = $curso->unidades;
		foreach($unidades as $unidad)
		{
			$unidad->actividades = $this->actividadEstudianteRepo->getByEstudianteByUnidad($estudiante->id, $unidad->id);
		}
		return view('estudiantes/ver_curso', compact('curso','unidades'));
	}

	public function companeros()
	{
		$ciclo = \Auth::user()->ciclo;
		$estudiante = \Auth::user()->persona;
		$seccion = $this->estudianteSeccionRepo->getByCicloByEstudiante($ciclo->id, $estudiante->id);
		$seccion = $seccion->seccion;
		if(is_null($seccion)){
			Session::flash('error', $estudiante->nombre_completo . ', no estás asignado a ninguna sección en el ciclo ' . $ciclo->descripcion);
		}
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		return view('estudiantes/companeros', compact('seccion','estudiantes'));
	}


}