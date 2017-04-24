<?php

namespace App\Http\Controllers;

use App\App\Repositories\DomoRepo;
use App\App\Managers\DomoManager;
use App\App\Entities\Domo;
use Controller, Redirect, Input, View, Session, Variable;

class DomoController extends BaseController {

	protected $domoRepo;

	public function __construct(DomoRepo $domoRepo)
	{
		$this->domoRepo = $domoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$domos = $this->domoRepo->all('nombre');
		return view('administracion/domos/listado', compact('domos'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/domos/agregar', compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new DomoManager(new Domo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el domo '.$data['nombre'].'con éxito.');
		return redirect(route('domos'));
	}

	public function mostrarEditar($id)
	{
		$domo = $this->domoRepo->find($id);
		$estados = Variable::getEstadosGenerales();
		return view('administracion/domos/editar', compact('domo','estados'));
	}

	public function editar($id)
	{
		$domo = $this->domoRepo->find($id);
		$data = Input::all();
		$manager = new DomoManager($domo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el domo '.$domo->nombre.'con éxito.');
		return redirect(route('domos'));
	}


}