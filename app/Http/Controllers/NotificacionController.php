<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, Variable;


class NotificacionController extends BaseController {

	public function __construct()
	{
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$persona = \Auth::user()->persona;
		$notificaciones = $persona->notifications;
		return view('administracion/notificaciones/listado', compact('notificaciones'));
	}

	public function ver($id)
	{
		$persona = \Auth::user()->persona;
		$notificacion = $persona->notifications()->where('id',$id)->firstOrFail();
		$notificacion->markAsRead();
		return view('administracion/notificaciones/ver', compact('notificacion'));
	}


}