<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, Variable, Excel, PDF;

use App\App\Repositories\CicloRepo;
use App\App\Repositories\SeccionRepo;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Repositories\TareaRepo;
use App\App\Repositories\TareaEstudianteRepo;

use App\App\Entities\Seccion;
use App\App\Entities\Curso;
use App\App\Entities\EstudianteSeccion;
use App\App\Entities\Tarea;

class EstudianteController extends BaseController {

	protected $cicloRepo;
	protected $seccionRepo;
	protected $cursoRepo;
	protected $estudianteSeccionRepo;
	protected $tareaRepo;
	protected $tareaEstudianteRepo;

	public function __construct(CicloRepo $cicloRepo, SeccionRepo $seccionRepo, CursoRepo $cursoRepo, EstudianteSeccionRepo $estudianteSeccionRepo, TareaRepo $tareaRepo, TareaEstudianteRepo $tareaEstudianteRepo)
	{
		$this->cicloRepo = $cicloRepo;
		$this->seccionRepo = $seccionRepo;
		$this->cursoRepo = $cursoRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;
		$this->tareaRepo = $tareaRepo;
		$this->tareaEstudianteRepo = $tareaEstudianteRepo;
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
		$cursos = $this->cursoRepo->getByCicloByEstudiante($ciclo->id, $estudiante->id);
		return view('estudiantes/dashboard', compact('secciones','cursos'));
	}

	public function verCurso(Curso $curso)
	{
		$estudiante = \Auth::user()->persona;
		$unidades = $curso->unidades;
		foreach($unidades as $unidad)
		{
			$unidad->tareas = $this->tareaEstudianteRepo->getByEstudianteByUnidad($estudiante->id, $unidad->id);
		}
		return view('estudiantes/ver_curso', compact('curso','unidades'));
	}


}