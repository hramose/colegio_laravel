<?php

namespace App\Http\Controllers;

use App\App\Repositories\SeccionRepo;
use App\App\Managers\SeccionManager;
use App\App\Entities\Seccion;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\GradoRepo;
use App\App\Repositories\CicloRepo;
use App\App\Repositories\PersonaRepo;
use App\App\Repositories\UnidadSeccionRepo;
use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\PlantillaUnidadRepo;

use App\App\Helpers\NotasHelper;

class SeccionController extends BaseController {

	protected $seccionRepo;
	protected $gradoRepo;
	protected $cicloRepo;
	protected $personaRepo;
	protected $unidadSeccionRepo;
	protected $estudianteSeccionRepo;
	protected $plantillaUnidadRepo;
	protected $cursoRepo;

	public function __construct(SeccionRepo $seccionRepo, GradoRepo $gradoRepo, CicloRepo $cicloRepo, PersonaRepo $personaRepo, UnidadSeccionRepo $unidadSeccionRepo, EstudianteSeccionRepo $estudianteSeccionRepo, CursoRepo $cursoRepo, PlantillaUnidadRepo $plantillaUnidadRepo)
	{
		$this->seccionRepo = $seccionRepo;
		$this->gradoRepo = $gradoRepo;
		$this->cicloRepo = $cicloRepo;
		$this->personaRepo = $personaRepo;
		$this->unidadSeccionRepo = $unidadSeccionRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;
		$this->cursoRepo = $cursoRepo;
		$this->plantillaUnidadRepo = $plantillaUnidadRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$ciclo = Variable::getCiclo();
		$secciones = $this->seccionRepo->getByCiclo($ciclo->id);
		return view('administracion/secciones/listado', compact('secciones','ciclo'));
	}

	public function mostrarAgregar()
	{
		$ciclo = Variable::getCiclo();
		$maestros = $this->personaRepo->getByRolByEstado(['M'],['A']);
		$grados = $this->gradoRepo->getByEstado(['A'],'descripcion');
		$secciones = Variable::getSecciones();
		$estados = Variable::getEstadosGenerales();
		$plantillas = $this->plantillaUnidadRepo->all('descripcion')->pluck('descripcion','id')->toArray();
		return view('administracion/secciones/agregar', 
			compact('ciclo','maestros','grados','secciones','estados','plantillas'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new SeccionManager(new Seccion(), $data);
		$ciclo = Variable::getCiclo();
		$manager->agregarSecciones($ciclo->id);
		Session::flash('success', 'Se agregaron las secciones con éxito.');
		return redirect(route('secciones'));
	}

	public function mostrarEditar($id)
	{
		$seccion = $this->seccionRepo->find($id);
		$maestros = $this->personaRepo->getByRolByEstado(['M'],['A'])->pluck('nombre_completo','id')->toArray();
		$grados = $this->gradoRepo->getByEstado(['A'],'descripcion')->pluck('descripcion','id')->toArray();
		$secciones = Variable::getSecciones();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/secciones/editar', compact('seccion','maestros','secciones','grados','estados'));
	}

	public function editar($id)
	{
		$seccion = $this->seccionRepo->find($id);
		$data = Input::all();
		$data['grado_id'] = $seccion->grado_id;
		$manager = new SeccionManager($seccion, $data);
		$manager->save();
		Session::flash('success', 'Se editó el grado ' . $seccion->grado->descripcion . ' sección' . $seccion->descripcion_seccion . ' con éxito.');
		return redirect(route('secciones'));
	}

	public function ver(Seccion $seccion)
	{
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);

		$notasHelper = new NotasHelper();
		$notas = $notasHelper->getNotasBySeccion($unidades, $estudiantes, $cursos, $seccion);
		return view('administracion.secciones.ver_seccion', compact('seccion','unidades','cursos','notas','estudiantes'));
	}


}