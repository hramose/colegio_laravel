<?php

namespace App\Http\Controllers;

use App\App\Repositories\CursoRepo;
use App\App\Managers\CursoManager;
use App\App\Entities\Curso;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\SeccionRepo;
use App\App\Repositories\PersonaRepo;
use App\App\Repositories\MateriaRepo;

class CursoController extends BaseController {

	protected $cursoRepo;
	protected $seccionRepo;
	protected $personaRepo;
	protected $materiaRepo;

	public function __construct(CursoRepo $cursoRepo, SeccionRepo $seccionRepo, PersonaRepo $personaRepo, MateriaRepo $materiaRepo)
	{
		$this->cursoRepo = $cursoRepo;
		$this->seccionRepo = $seccionRepo;
		$this->personaRepo = $personaRepo;
		$this->materiaRepo = $materiaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($seccionId)
	{
		$seccion = $this->seccionRepo->find($seccionId);
		$cursos = $this->cursoRepo->getBySeccion($seccionId);
		return view('administracion/cursos/listado', compact('cursos','seccion'));
	}

	public function mostrarAgregar($seccionId)
	{
		$seccion = $this->seccionRepo->find($seccionId);
		$maestros = $this->personaRepo->getByRolByEstado(['M'],['A']);
		$materias = $this->materiaRepo->getByEstado(['A'],'descripcion');		
		return view('administracion/cursos/agregar', compact('seccion','maestros','materias'));
	}

	public function agregar($seccionId)
	{
		$data = Input::all();
		$manager = new CursoManager(null, $data);
		$manager->agregarCursos($seccionId);
		$seccion = $this->seccionRepo->find($seccionId);
		Session::flash('success', 'Se agregaron los cursos a '.$seccion->grado->descripcion .' '.$seccion->descripcion_seccion.' con éxito.');
		return redirect()->route('cursos',$seccion->id);
	}

	public function mostrarEditar($id)
	{
		$curso = $this->cursoRepo->find($id);
		$maestros = $this->personaRepo->getByRolByEstado(['M'],['A'])->pluck('nombre_completo','id')->toArray();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/cursos/editar', compact('curso','estados','maestros'));
	}

	public function editar($id)
	{
		$curso = $this->cursoRepo->find($id);
		$data = Input::all();
		$data['materia_id'] = $curso->materia_id;
		$data['estado'] = $curso->estado;
		$manager = new CursoManager($curso, $data);
		$manager->save();
		Session::flash('success', 'Se editó el curso '.$curso->materia->descripcion.' de '.$curso->seccion->grado->descripcion.' '.$curso->seccion->descripcion_seccion.' con éxito.');
		return redirect()->route('cursos', $curso->id);
	}


}