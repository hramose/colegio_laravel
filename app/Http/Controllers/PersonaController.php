<?php

namespace App\Http\Controllers;

use App\App\Repositories\PersonaRepo;
use App\App\Managers\PersonaManager;
use App\App\Entities\Persona;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\PaisRepo;

class PersonaController extends BaseController {

	protected $personaRepo;
	protected $paisRepo;

	public function __construct(PersonaRepo $personaRepo, PaisRepo $paisRepo)
	{
		$this->personaRepo = $personaRepo;
		$this->paisRepo = $paisRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$personas = $this->personaRepo->all('primer_nombre');
		return view('administracion/personas/listado', compact('personas'));
	}

	public function mostrarAgregar()
	{
		$roles = Variable::getRoles();
		$posiciones = Variable::getPosiciones();
		$estados = Variable::getEstadosGenerales();
		$paises = $this->paisRepo->lists('nombre','id');
		return view('administracion/personas/agregar',compact('roles','posiciones','paises','estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new PersonaManager(new Persona(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la persona con éxito.');
		return redirect(route('personas'));
	}

	public function mostrarEditar($id)
	{
		$roles = Variable::getRoles();
		$posiciones = Variable::getPosiciones();
		$estados = Variable::getEstadosGenerales();
		$paises = $this->paisRepo->lists('nombre','id');
		$persona = $this->personaRepo->find($id);
		return view('administracion/personas/editar', compact('persona','roles','posiciones','paises','estados'));
	}

	public function editar($id)
	{
		$persona = $this->personaRepo->find($id);
		$data = Input::all();
		$manager = new PersonaManager($persona, $data);
		$manager->save();
		Session::flash('success', 'Se editó la persona con éxito.');
		return redirect(route('personas'));
	}


}