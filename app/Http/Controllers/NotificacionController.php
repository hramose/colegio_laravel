<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, View, Session, Variable;


class NotificacionController extends BaseController {

	public function __construct()
	{
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	/*
	* 0 = todas
	* 1 = leidas
	* 2 = no-leidas
	*/
	public function listado($tipo)
	{
		$persona = \Auth::user()->persona;
		if($tipo==1)
			$notificaciones = $persona->readNotifications;
		elseif($tipo==2)
			$notificaciones = $persona->unreadNotifications;
		else
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