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
		$maestros = $this->personaRepo->getByRol(['M']);
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

	/*Estudiantes*/
	public function estudiantes()
	{
		$estudiantes = $this->personaRepo->getByRol(['E']);
		return view('administracion/personas/listado_estudiantes', compact('estudiantes'));
	}

	public function mostrarAgregarEstudiante()
	{
		$generos = Variable::getGeneros();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/personas/agregar_estudiante',compact('generos','estados'));
	}

	public function agregarEstudiante()
	{
		$data = Input::all();
		$manager = new PersonaManager(new Persona(), $data);
		$estudiante = $manager->saveEstudiante();
		Session::flash('success', 'Se agregó el estudiante '.$estudiante->nombre_completo.' con éxito.');
		return redirect(route('estudiantes'));
	}

	public function mostrarCargarEstudiantes()
	{
		$generos = Variable::getGeneros();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/personas/cargar_estudiantes',compact('generos','estados'));
	}

	public function cargarEstudiantes()
	{
		$data = Input::all();
		$manager = new PersonaManager(null, $data);
		$estudiante = $manager->cargarEstudiantes();
		Session::flash('success', 'Se cargaron los estudiantes con éxito.');
		return redirect(route('estudiantes'));
	}

	public function mostrarEditarEstudiante($id)
	{
		$generos = Variable::getGeneros();
		$estados = Variable::getEstadosGenerales();
		$estudiante = $this->personaRepo->find($id);
		return view('administracion/personas/editar_estudiante', compact('generos','estudiante','estados'));
	}

	public function editarEstudiante($id)
	{
		$estudiante = $this->personaRepo->find($id);
		$data = Input::all();
		$manager = new PersonaManager($estudiante, $data);
		$manager->saveEstudiante();
		Session::flash('success', 'Se editó el estudiante '.$estudiante->nombre_completo.' con éxito.');
		return redirect(route('estudiantes'));
	}


}