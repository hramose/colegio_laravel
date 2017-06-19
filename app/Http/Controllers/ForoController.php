<?php

namespace App\Http\Controllers;

use App\App\Repositories\ForoRepo;
use App\App\Managers\ForoManager;
use App\App\Entities\Foro;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Curso;
use App\App\Repositories\CursoRepo;

class ForoController extends BaseController {

	protected $foroRepo;
	protected $cursoRepo;

	public function __construct(ForoRepo $foroRepo, CursoRepo $cursoRepo)
	{
		$this->foroRepo = $foroRepo;
		$this->cursoRepo = $cursoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Curso $curso)
	{
		$foros = $this->foroRepo->getByCurso($curso->id);
		return view('administracion/foros/listado', compact('foros','curso'));
	}

    public function mostrarAgregar(Curso $curso)
    {
        return view('administracion/foros/agregar', compact('curso'));
    }

    public function agregar(Curso $curso)
    {
        $data = Input::all();
        $data['curso_id'] = $curso->id;
        $data['autor_id'] = \Auth::user()->persona_id;
        $data['estado'] = 'A';
        $manager = new ForoManager(new Foro(), $data);
        $manager->agregar();
        Session::flash('success', 'Se agregó el foro ' . $data['tema'] . ' con éxito.');
        return redirect()->route('foros',$curso->id);
    }

	public function mostrarEditar(Foro $Foro)
	{
		return view('administracion/foros/editar', compact('Foro'));
	}

	public function editar(Foro $foro)
	{
		$data = Input::all();
        $data['curso_id'] = $foro->curso_id;
        $data['autor_id'] = $foro->autor_id;
        $data['estado'] = 'A';
		$manager = new ForoManager($foro, $data);
		$manager->save();
		Session::flash('success', 'Se editó el foro '.$foro->tema.' con éxito.');
		return redirect()->route('foros',$foro->curso_id);
	}


}