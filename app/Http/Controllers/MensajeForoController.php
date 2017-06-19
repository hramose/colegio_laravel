<?php

namespace App\Http\Controllers;

use App\App\Repositories\MensajeForoRepo;
use App\App\Managers\MensajeForoManager;
use App\App\Entities\MensajeForo;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Foro;
use App\App\Repositories\ForoRepo;

class MensajeForoController extends BaseController {

	protected $mensajeForoRepo;
	protected $foroRepo;

	public function __construct(MensajeForoRepo $mensajeForoRepo, ForoRepo $foroRepo)
	{
		$this->mensajeForoRepo = $mensajeForoRepo;
		$this->foroRepo = $foroRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Foro $foro)
	{
        $foro->visitas = $foro->visitas + 1;
        $foro->save();
		$mensajes = $this->mensajeForoRepo->getByForo($foro->id);
		return view('administracion/mensajes_foro/listado', compact('mensajes','foro'));
	}

    public function mostrarAgregar(Foro $foro)
    {
        return view('administracion/mensajes_foro/agregar', compact('foro'));
    }

    public function agregar(Foro $foro)
    {
        $data = Input::all();
        $data['foro_id'] = $foro->id;
        $data['autor_id'] = \Auth::user()->persona_id;
        $data['estado'] = 'A';
        $manager = new MensajeForoManager(new MensajeForo(), $data);
        $manager->save();
        Session::flash('success', 'Se agregó el mensaje al foro ' . $foro->tema . ' con éxito.');
        return redirect()->route('mensajes_foro',$foro->id);
    }

	public function mostrarEditar(MensajeForo $mensajeForo)
	{
		return view('administracion/mensajes_foro/editar', compact('mensajeForo'));
	}

	public function editar(MensajeForo $mensajeForo)
	{
		$data = Input::all();
        $data['Foro_id'] = $mensajeForo->Foro_id;
        $data['autor_id'] = $mensajeForo->autor_id;
        $data['estado'] = 'A';
		$manager = new MensajeForoManager($mensajeForo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el MensajeForo '.$mensajeForo->tema.' con éxito.');
		return redirect()->route('mensajes_foro',$mensajeForo->Foro_id);
	}


}