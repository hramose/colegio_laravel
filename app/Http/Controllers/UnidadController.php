<?php

namespace App\Http\Controllers;

use App\App\Repositories\UnidadRepo;
use App\App\Managers\UnidadManager;
use App\App\Entities\Unidad;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Curso;
use App\App\Repositories\CursoRepo;

class UnidadController extends BaseController {

	protected $unidadRepo;
	protected $cursoRepo;

	public function __construct(UnidadRepo $unidadRepo, CursoRepo $cursoRepo)
	{
		$this->unidadRepo = $unidadRepo;
		$this->cursoRepo = $cursoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Curso $curso)
	{
		$unidades = $this->unidadRepo->all('unidad');
		$totalPorcentaje = 0;
		foreach($unidades as $unidad)
			$totalPorcentaje += $unidad->porcentaje;
		return view('administracion/unidades/listado', compact('unidades','curso','totalPorcentaje'));
	}

	public function mostrarAgregar(Curso $curso)
	{
		$unidades = Variable::getUnidades();
		return view('administracion/unidades/agregar',compact('curso','unidades'));
	}

	public function agregar(Curso $curso)
	{
		$data = Input::all();
		$data['curso_id'] = $curso->id;
		$data['estado'] = 'A';
		$manager = new UnidadManager(new Unidad(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la unidad con éxito.');
		return redirect()->route('unidades',$curso->id);
	}

	public function mostrarEditar(Unidad $unidad)
	{
		return view('administracion/unidades/editar', compact('unidad'));
	}

	public function editar(Unidad $unidad)
	{
		$data = Input::all();
		$data['curso_id'] = $unidad->curso_id;
		$data['estado'] = $unidad->estado;
		$data['unidad'] = $unidad->unidad;
		$manager = new UnidadManager($unidad, $data);
		$manager->save();
		Session::flash('success', 'Se editó la unidad con éxito.');
		return redirect()->route('unidades',$unidad->curso_id);
	}


}