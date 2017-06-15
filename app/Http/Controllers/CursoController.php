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
		$materias = $this->materiaRepo->getNotInSeccionByEstado($seccionId, ['A']);		
		return view('administracion/cursos/agregar', compact('seccion','maestros','materias'));
	}

	public function agregar($seccionId)
	{
		$data = Input::all();
		$manager = new CursoManager(null, $data);
		$seccion = $this->seccionRepo->find($seccionId);
		$manager->agregarCursos($seccionId, $seccion->unidades);
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

	/*
		*seccionId es la seccion a la que se trasladaran
		*seccion2Id es la seccion de la cual se trasladan
	*/
	public function mostrarTrasladar($seccionId, $seccion2Id)
	{
		$ciclo = Variable::getCiclo();
		$secciones = $this->seccionRepo->getByCicloByEstado($ciclo->id, ['A'])->pluck('descripcion_con_grado','id')->toArray();
		$seccion = $this->seccionRepo->find($seccionId);
		$seccion2 = $this->seccionRepo->find($seccion2Id);
		$cursos = $this->cursoRepo->getBySeccionByMateriasNotInSeccion($seccionId, $seccion2Id);
		return view('administracion/cursos/trasladar', compact('cursos','seccion','seccion2','seccionId','seccion2Id','secciones'));
	}

	public function trasladar($seccionId, $seccion2Id)
	{
		$data = Input::all();
		$manager = new CursoManager(null, $data);
		$manager->agregarCursos($seccionId);
		$seccion = $this->seccionRepo->find($seccionId);
		Session::flash('success', 'Se agregaron los cursos a '.$seccion->grado->descripcion .' '.$seccion->descripcion_seccion.' con éxito.');
		return redirect()->route('cursos',$seccion->id);
	}


}