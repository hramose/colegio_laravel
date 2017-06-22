<?php

namespace App\Http\Controllers;

use App\App\Repositories\CicloRepo;
use App\App\Managers\CicloManager;
use App\App\Entities\Ciclo;
use Controller, Redirect, Input, View, Session, Variable;

class CicloController extends BaseController {

	protected $cicloRepo;

	public function __construct(CicloRepo $cicloRepo)
	{
		$this->cicloRepo = $cicloRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$ciclos = $this->cicloRepo->all('descripcion');
		return view('administracion/ciclos/listado', compact('ciclos'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/ciclos/agregar', compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new CicloManager(new Ciclo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el ciclo '.$data['descripcion'].' con éxito.');
		return redirect(route('ciclos'));
	}

	public function mostrarEditar($id)
	{
		$ciclo = $this->cicloRepo->find($id);
		$estados = Variable::getEstadosGenerales();
		return view('administracion/ciclos/editar', compact('ciclo','estados'));
	}

	public function editar($id)
	{
		$ciclo = $this->cicloRepo->find($id);
		$data = Input::all();
		$manager = new CicloManager($ciclo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el ciclo '.$ciclo->descripcion.' con éxito.');
		return redirect(route('ciclos'));
	}

	public function mostrarElegir(){
		$ciclos = $this->cicloRepo->getByEstado(['A'],'fecha_inicio');
		$actual = 0;
		foreach ($ciclos as $key => $ciclo) {
			if($ciclo->actual){
				$actual = $ciclo->id;
			}
		}
		return View::make('administracion/elegir_ciclo', compact('ciclos', 'actual'));
	}

	public function elegir(){
		$id = Input::get('ciclo_id');
		$ciclo = $this->cicloRepo->find($id);
		$user = \Auth::user();
		$user->ciclo_id = $ciclo->id;
		$user->save();
		if($user->perfil_id == 3)
			return Redirect::route('maestros.dashboard');
		if($user->perfil_id == 4)
			return Redirect::route('estudiantes.dashboard');
		return Redirect::route('dashboard');		
	}


}