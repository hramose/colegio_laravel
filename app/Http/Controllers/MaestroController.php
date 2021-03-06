<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, Variable, Excel, PDF, Gate;

use App\App\Repositories\CicloRepo;
use App\App\Repositories\SeccionRepo;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Repositories\ActividadRepo;
use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Repositories\ForoRepo;
use App\App\Repositories\UnidadSeccionRepo;

use App\App\Managers\UnidadCursoManager;

use App\App\Entities\Seccion;
use App\App\Entities\Curso;
use App\App\Entities\EstudianteSeccion;
use App\App\Entities\Actividad;
use App\App\Entities\UnidadCurso;

use App\App\Helpers\NotasHelper;

class MaestroController extends BaseController {

	protected $cicloRepo;
	protected $seccionRepo;
	protected $cursoRepo;
	protected $estudianteSeccionRepo;
	protected $actividadRepo;
	protected $actividadEstudianteRepo;
	protected $foroRepo;
	protected $unidadSeccionRepo;

	public function __construct(CicloRepo $cicloRepo, SeccionRepo $seccionRepo, CursoRepo $cursoRepo, EstudianteSeccionRepo $estudianteSeccionRepo, ActividadRepo $actividadRepo, ActividadEstudianteRepo $actividadEstudianteRepo, ForoRepo $foroRepo, UnidadSeccionRepo $unidadSeccionRepo)
	{
		$this->cicloRepo = $cicloRepo;
		$this->seccionRepo = $seccionRepo;
		$this->cursoRepo = $cursoRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;
		$this->actividadRepo = $actividadRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		$this->foroRepo = $foroRepo;
		$this->unidadSeccionRepo = $unidadSeccionRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function dashboard()
	{
		$ciclo = \Auth::user()->ciclo;
		$maestro = \Auth::user()->persona;
		$secciones = $this->seccionRepo->getByCicloByMaestro($ciclo->id, $maestro->id);
		$cursos = $this->cursoRepo->getByCicloByMaestro($ciclo->id, $maestro->id);
		return view('maestros/dashboard', compact('secciones','cursos'));
	}

	public function estudiantesSeccion(Seccion $seccion)
	{
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		return view('maestros/estudiantes_seccion', compact('seccion','estudiantes'));	
	}

	public function estudiantesCurso(Curso $curso)
	{
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($curso->seccion_id);
		return view('maestros/estudiantes_curso', compact('curso','estudiantes'));	
	}

	public function secciones()
	{
		$ciclo = \Auth::user()->ciclo;
		$maestro = \Auth::user()->persona;
		$secciones = $this->seccionRepo->getByCicloByMaestro($ciclo->id, $maestro->id);
		if(count($secciones) == 1)
		{
			return redirect()->route('maestros.ver_seccion',$secciones[0]->id);
		}
		return view('maestros/secciones', compact('secciones','maestro'));
	}

	public function verSeccion(Seccion $seccion)
	{
		if(Gate::denies('permiso_seccion', $seccion)){
			Session::flash('error','No tiene permiso para ver la seccion.');
			return redirect()->back();
		}
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);

		$notasHelper = new NotasHelper();
		$notas = $notasHelper->getNotasBySeccion($unidades, $estudiantes, $cursos, $seccion);
		return view('maestros.ver_seccion', compact('seccion','cursos','notas','estudiantes'));
	}

	public function cursos()
	{
		$ciclo = \Auth::user()->ciclo;
		$maestro = \Auth::user()->persona;
		$cursos = $this->cursoRepo->getByCicloByMaestro($ciclo->id, $maestro->id);
		return view('maestros/cursos', compact('cursos','maestro'));
	}

	public function verCurso(Curso $curso)
	{
		if(Gate::denies('permiso_curso', $curso)){
			Session::flash('error','No tiene permiso para ver el curso.');
			return redirect()->back();
		}
		$unidades = $curso->unidades;
		//$foros = $this->foroRepo->getByCurso($curso->id);
		//throw new \Exception('es');
		return view('maestros/ver_curso', compact('curso'));	
	}

	public function reporteEstudiantesSeccion(Seccion $seccion, $tipo)
	{
		if(Gate::denies('permiso_seccion', $seccion)){
			Session::flash('error','No tiene permiso para ver la seccion.');
			return redirect()->back();
		}
		$estudiantesDB = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		$estudiantes = [];
		foreach($estudiantesDB as $estudiante)
		{
			$e['CODIGO'] = $estudiante->codigo;
			$e['NOMBRE'] = $estudiante->estudiante->nombre_completo;
			$estudiantes[] = $e;
		}
		$nombreArchivo = 'Listado de Estudiantes - ' . $seccion->grado->descripcion . ' ' . $seccion->descripcion_seccion;
		if($tipo == 'excel')
			Excel::create($nombreArchivo, function($excel) use ($estudiantes) {
			    $excel->sheet('Estudiantes', function($sheet) use ($estudiantes) {
			        $sheet->fromArray($estudiantes);
			    });
			})->export('xlsx');
	}

	public function reporteEstudiantesCurso(Curso $curso, $tipo)
	{
		if(Gate::denies('permiso_curso', $curso)){
			Session::flash('error','No tiene permiso para ver el curso.');
			return redirect()->back();
		}
		$estudiantesDB = $this->estudianteSeccionRepo->getBySeccion($curso->seccion_id);
		$estudiantes = [];
		foreach($estudiantesDB as $estudiante)
		{
			$e['CODIGO'] = $estudiante->codigo;
			$e['NOMBRE'] = $estudiante->estudiante->nombre_completo;
			$estudiantes[] = $e;
		}
		$nombreArchivo = 'Listado de Estudiantes - '. $curso->materia->descripcion . ' - ' . $curso->seccion->grado->descripcion . ' ' . $curso->seccion->descripcion_seccion;
		if($tipo == 'excel')
			Excel::create($nombreArchivo, function($excel) use ($estudiantes) {
			    $excel->sheet('Estudiantes', function($sheet) use ($estudiantes) {
			        $sheet->fromArray($estudiantes);
			    });
			})->export('xlsx');
	}


}