<?php

namespace App\Http\Controllers;

use App\App\Repositories\PersonaRepo;
use App\App\Managers\PersonaManager;
use App\App\Entities\Persona;
use Controller, Redirect, Input, View, Session, Variable;

class PersonaController extends BaseController {

	protected $personaRepo;

	public function __construct(PersonaRepo $personaRepo)
	{
		$this->personaRepo = $personaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	/*Maestros*/
	public function maestros()
	{
		$maestros = $this->personaRepo->all('primer_nombre');
		return view('administracion/personas/listado_maestros', compact('maestros'));
	}

	public function mostrarAgregarMaestro()
	{
		$generos = Variable::getGeneros();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/personas/agregar_maestro',compact('generos','estados'));
	}

	public function agregarMaestro()
	{
		$data = Input::all();
		$manager = new PersonaManager(new Persona(), $data);
		$maestro = $manager->saveMaestro();
		Session::flash('success', 'Se agregó el maestro '.$maestro->nombre_completo.' con éxito.');
		return redirect(route('maestros'));
	}

	public function mostrarEditarMaestro($id)
	{
		$generos = Variable::getGeneros();
		$estados = Variable::getEstadosGenerales();
		$maestro = $this->personaRepo->find($id);
		return view('administracion/personas/editar_maestro', compact('generos','maestro','estados'));
	}

	public function editarMaestro($id)
	{
		$maestro = $this->personaRepo->find($id);
		$data = Input::all();
		$manager = new PersonaManager($maestro, $data);
		$manager->saveMaestro();
		Session::flash('success', 'Se editó el maestro '.$maestro->nombre_completo.' con éxito.');
		return redirect(route('maestros'));
	}


}