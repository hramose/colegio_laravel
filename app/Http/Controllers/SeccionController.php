<?php

namespace App\Http\Controllers;

use App\App\Repositories\SeccionRepo;
use App\App\Managers\SeccionManager;
use App\App\Entities\Seccion;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\GradoRepo;
use App\App\Repositories\CicloRepo;
use App\App\Repositories\PersonaRepo;

class SeccionController extends BaseController {

	protected $seccionRepo;
	protected $gradoRepo;
	protected $cicloRepo;
	protected $personaRepo;

	public function __construct(SeccionRepo $seccionRepo, GradoRepo $gradoRepo, CicloRepo $cicloRepo, PersonaRepo $personaRepo)
	{
		$this->seccionRepo = $seccionRepo;
		$this->gradoRepo = $gradoRepo;
		$this->cicloRepo = $cicloRepo;
		$this->personaRepo = $personaRepo;
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
		return view('administracion/secciones/agregar', 
			compact('ciclo','maestros','grados','secciones','estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new SeccionManager(new Seccion(), $data);
		$ciclo = Variable::getCiclo();
		$manager->agregarSecciones($this->ciclo->id);
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
		$manager = new SeccionManager($seccion, $data);
		$manager->save();
		Session::flash('success', 'Se editó el grado ' . $seccion->grado->descripcion . ' sección' . $seccion->descripcion_seccion . ' con éxito.');
		return redirect(route('secciones'));
	}


}