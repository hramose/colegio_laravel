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
		return View::make('administracion/ciclos/elegir', compact('ciclos'));
	}

	public function elegir(){
		$id = Input::get('ciclo_id');
		$ciclo = $this->cicloRepo->find($id);
		session(['ciclo_id' => $ciclo->id]);
		session(['ciclo_nombre' => $ciclo->descripcion]);
		return Redirect::route('dashboard');		
	}


}