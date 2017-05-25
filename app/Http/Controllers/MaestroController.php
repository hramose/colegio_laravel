<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\CicloRepo;
use App\App\Repositories\SeccionRepo;
use App\App\Repositories\CursoRepo;

class MaestroController extends BaseController {

	protected $cicloRepo;
	protected $seccionRepo;
	protected $cursoRepo;

	public function __construct(CicloRepo $cicloRepo, SeccionRepo $seccionRepo, CursoRepo $cursoRepo)
	{
		$this->cicloRepo = $cicloRepo;
		$this->seccionRepo = $seccionRepo;
		$this->cursoRepo = $cursoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function dashboard()
	{
		$ciclo = \Auth::user()->ciclo;
		$maestro = \Auth::user()->persona;
		$secciones = $this->seccionRepo->getByCicloByMaestro($ciclo->id, $maestro->id);
		$cursos = $this->cursoRepo->getByCicloByMaestro($ciclo->id, $maestro->id);
		Session::flash('succes','Hola ' . $maestro->nombre_completo);
		return view('maestros/dashboard', compact('secciones','cursos'));
	}


}