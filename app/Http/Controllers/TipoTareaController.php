<?php

namespace App\Http\Controllers;

use Variable;

use App\App\Repositories\TipoTareaRepo;
use App\App\Managers\TipoTareaManager;
use App\App\Entities\TipoTarea;
use Controller, Redirect, Input, View, Session;

class TipoTareaController extends BaseController {

	protected $tipoTareaRepo;

	public function __construct(TipoTareaRepo $tipoTareaRepo)
	{
		$this->tipoTareaRepo = $tipoTareaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$tipos = $this->tipoTareaRepo->all('descripcion');
		return view('administracion/tipos_tareas/listado', compact('tipos'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/tipos_tareas/agregar',compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new TipoTareaManager(new TipoTarea(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el tipo de tarea '.$data['descripcion'].' con éxito.');
		return redirect()->route('tipos_tareas');
	}

	public function mostrarEditar($id)
	{
		$estados = Variable::getEstadosGenerales();
		$tipoTarea = $this->tipoTareaRepo->find($id);
		return view('administracion/tipos_tareas/editar', compact('tipoTarea','estados'));
	}

	public function editar($id)
	{
		$tipoTarea = $this->tipoTareaRepo->find($id);
		$data = Input::all();
		$manager = new TipoTareaManager($tipoTarea, $data);
		$manager->save();
		Session::flash('success', 'Se editó el tipo de tarea '.$tipoTarea->descripcion.' con éxito.');
		return redirect()->route('tipos_tareas');
	}


}