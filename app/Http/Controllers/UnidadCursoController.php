<?php

namespace App\Http\Controllers;

use App\App\Repositories\UnidadCursoRepo;
use App\App\Managers\UnidadCursoManager;
use App\App\Entities\UnidadCurso;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Curso;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\ActividadRepo;

class UnidadCursoController extends BaseController {

	protected $unidadCursoRepo;
	protected $cursoRepo;
	protected $actividadRepo;

	public function __construct(UnidadCursoRepo $unidadCursoRepo, CursoRepo $cursoRepo, ActividadRepo $actividadRepo)
	{
		$this->unidadCursoRepo = $unidadCursoRepo;
		$this->cursoRepo = $cursoRepo;
		$this->actividadRepo = $actividadRepo;
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


}