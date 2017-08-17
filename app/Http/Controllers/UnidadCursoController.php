<?php

namespace App\Http\Controllers;

use App\App\Repositories\UnidadCursoRepo;
use App\App\Managers\UnidadCursoManager;
use App\App\Entities\UnidadCurso;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Curso;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\ActividadRepo;
use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Repositories\EstudianteSeccionRepo;

class UnidadCursoController extends BaseController {

	protected $unidadCursoRepo;
	protected $cursoRepo;
	protected $actividadRepo;
	protected $actividadEstudianteRepo;
	protected $estudianteSeccionRepo;

	public function __construct(UnidadCursoRepo $unidadCursoRepo, CursoRepo $cursoRepo, ActividadRepo $actividadRepo, ActividadEstudianteRepo $actividadEstudianteRepo, EstudianteSeccionRepo $estudianteSeccionRepo)
	{
		$this->unidadCursoRepo = $unidadCursoRepo;
		$this->cursoRepo = $cursoRepo;
		$this->actividadRepo = $actividadRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Curso $curso)
	{
		$unidades = $this->unidadCursoRepo->getByCurso($curso->id);
		foreach($unidades as $unidad){
			$unidad->actividades = $this->actividadRepo->getByUnidad($unidad->id);
		}

		return view('administracion/unidades_cursos/listado', compact('unidades','curso'));
	}

	public function mostrarEditar(UnidadCurso $unidadCurso)
	{
		return view('administracion/unidades_cursos/editar', compact('unidadCurso'));
	}

	public function editar(UnidadCurso $unidadCurso)
	{
		$data = Input::all();
		$data['curso_id'] = $unidadCurso->curso_id;
		$data['unidad_seccion_id'] = $unidadCurso->unidad_seccion_id;
		$data['estado'] = $unidadCurso->estado;
		$manager = new UnidadCursoManager($unidadCurso, $data);
		$manager->save();
		Session::flash('success', 'Se editó la planificación de unidad del curso con éxito.');
		return redirect()->route('unidades_curso',$unidadCurso->curso_id);
	}

	public function mostrarNotas(UnidadCurso $unidadCurso)
	{
		$actividades = $this->actividadRepo->getByUnidad($unidadCurso->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($unidadCurso->curso->seccion_id);
		$actividadesEstudiantes = $this->actividadEstudianteRepo->getByUnidad($unidadCurso->id);
		$notas = [];
	
		$headers[] = 'ESTUDIANTE';	
		foreach($actividades as $actividad)
		{
			$headers[] = $actividad->id;
		}
		$headers[] = 'TOTAL';

		foreach($estudiantes as $estudiante)
		{
			$notas[$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante->nombre_completo;
			foreach($actividades as $actividad)
			{
				$notas[$estudiante->estudiante_id][$actividad->id] = $actividad->id;
			}
			$notas[$estudiante->estudiante_id]['total'] = 0;
		}

		foreach($actividadesEstudiantes as $ae)
		{
			$notas[$ae->estudiante_id][$ae->actividad_id] = $ae->nota;
			$notas[$ae->estudiante_id]['total'] += $ae->nota;
		}

		
		


		/*foreach($actividadesEstudiantes as $ae)
		{
			foreach ($headers as $header) 
			{
				if($header == 'estudiante'){
					$notas[$ae->estudiante_id]['estudiante'] = $ae->estudiante->nombre_completo;
				}
				elseif($header == 'total'){
					if(!isset($notas[$ae->estudiante_id]['total']))
						$notas[$ae->estudiante_id]['total'] = 0;
					$notas[$ae->estudiante_id]['total'] += $ae->nota;
				}
				elseif($ae->actividad_id == $header){
					$notas[$ae->estudiante_id][$header] = $ae->nota;
				}
			}
		}*/

		

		/*foreach($actividades as $actividad)
		{
			if(!isset($notas[$actividad->estudiante_id]))
			{
				$notas[$actividad->estudiante_id]['estudiante_id'] = $actividad->estudiante_id;
				$notas[$actividad->estudiante_id]['estudiante'] = $actividad->estudiante->nombre_completo;
				$notas[$actividad->estudiante_id]['nota'] = 0;
			}
			$notas[$actividad->estudiante_id]['nota'] += $actividad->nota;
		}*/
		return view('administracion/unidades_cursos/notas', compact('unidadCurso','notas','headers','actividades'));
	}


}