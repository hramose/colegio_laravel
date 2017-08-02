<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, Variable, Excel, PDF;

use App\App\Repositories\CicloRepo;
use App\App\Repositories\SeccionRepo;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Repositories\ActividadRepo;
use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Repositories\UnidadCursoRepo;
use App\App\Repositories\ForoRepo;

use App\App\Entities\Seccion;
use App\App\Entities\Curso;
use App\App\Entities\EstudianteSeccion;
use App\App\Entities\Actividad;
use App\App\Entities\ActividadEstudiante;
use App\App\Entities\Foro;


class EstudianteController extends BaseController {

	protected $cicloRepo;
	protected $seccionRepo;
	protected $cursoRepo;
	protected $estudianteSeccionRepo;
	protected $actividadRepo;
	protected $actividadEstudianteRepo;
	protected $unidadCursoRepo;
	protected $foroRepo;

	public function __construct(CicloRepo $cicloRepo, SeccionRepo $seccionRepo, CursoRepo $cursoRepo, EstudianteSeccionRepo $estudianteSeccionRepo, ActividadRepo $actividadRepo, ActividadEstudianteRepo $actividadEstudianteRepo, UnidadCursoRepo $unidadCursoRepo, ForoRepo $foroRepo)
	{
		$this->cicloRepo = $cicloRepo;
		$this->seccionRepo = $seccionRepo;
		$this->cursoRepo = $cursoRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;
		$this->actividadRepo = $actividadRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		$this->unidadCursoRepo = $unidadCursoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function dashboard()
	{
		$ciclo = \Auth::user()->ciclo;
		$estudiante = \Auth::user()->persona;
		$seccion = $this->estudianteSeccionRepo->getByCicloByEstudiante($ciclo->id, $estudiante->id);
		if(is_null($seccion)){
			Session::flash('error', $estudiante->nombre_completo . ', no estás asignado a ninguna sección en el ciclo ' . $ciclo->descripcion);
			\Auth::logout();
			return redirect()->route('login');
		}
		$seccion = $seccion->seccion;
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		$cantidadEstudiantes = count($seccion->estudiantes);
		$cantidadCursos = count($cursos);
		return view('estudiantes/dashboard', compact('seccion','cursos', 'cantidadEstudiantes','cantidadCursos'));
	}

	public function verCurso(Curso $curso)
	{
		return view('estudiantes/ver_curso', compact('curso'));
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

	public function cursos()
	{
		$ciclo = \Auth::user()->ciclo;
		$estudiante = \Auth::user()->persona;
		$seccion = $this->estudianteSeccionRepo->getByCicloByEstudiante($ciclo->id, $estudiante->id);
		$seccion = $seccion->seccion;
		if(is_null($seccion)){
			Session::flash('error', $estudiante->nombre_completo . ', no estás asignado a ninguna sección en el ciclo ' . $ciclo->descripcion);
		}
		$cursos = $this->cursoRepo->getBySeccion($seccion->id)->load('foros');
		return view('estudiantes/cursos', compact('seccion','cursos'));
	}

	public function unidades(Curso $curso)
	{
		$estudiante = \Auth::user()->persona;
		$unidades = $this->unidadCursoRepo->getByCurso($curso->id);
		foreach($unidades as $unidad){
			$unidad->actividades = $this->actividadEstudianteRepo->getByEstudianteByUnidad($estudiante->id, $unidad->id);
		}

		return view('estudiantes/unidades', compact('unidades','curso'));
	}

	public function foros(Curso $curso)
	{
		$foros = $this->foroRepo->getByCurso($curso->id);
		return view('estudiantes/foros', compact('foros','curso'));
	}

	public function mensajesForo(Foro $foro)
	{
		$mensajes = $foro->mensajes;
		return view('estudiantes/mensajes_foro', compact('foro','mensajes'));
	}

	public function maestros()
	{
		$ciclo = \Auth::user()->ciclo;
		$estudiante = \Auth::user()->persona;
		$seccion = $this->estudianteSeccionRepo->getByCicloByEstudiante($ciclo->id, $estudiante->id);
		$seccion = $seccion->seccion;
		if(is_null($seccion)){
			Session::flash('error', $estudiante->nombre_completo . ', no estás asignado a ninguna sección en el ciclo ' . $ciclo->descripcion);
		}
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		return view('estudiantes/maestros', compact('seccion','cursos'));
	}

	public function verActividad(ActividadEstudiante $actividadEstudiante)
	{
		return view('estudiantes/ver_actividad', compact('actividadEstudiante'));
	}

	public function mostrarEntregarActividad(ActividadEstudiante $actividad)
	{
		return view('estudiantes/entregar_actividad', compact('actividadEstudiante'));	
	}

	public function entregarActividad(ActividadEstudiante $actividad)
	{
		$data = Input::all();
		$data['estado'] = 'E';
		$data['fecha_entrega'] = date('Y-m-d H:i:s');
		$manager = new ActividadEstudianteManager($actividad, $data);
		$manager->entregar();
		Session::flash('success', 'Has entregado tu actividad con éxito');
	}


}
