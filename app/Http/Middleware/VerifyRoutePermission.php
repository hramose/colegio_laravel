<?php

namespace App\Http\Middleware;

use Closure, Redirect, Session, Variable, Auth, Route, Gate;

class VerifyRoutePermission
{

    public function handle($request, Closure $next)
    {
    	if (Auth::guest()) return Redirect::guest('login');
	
		$ruta = Route::currentRouteName();
		if(Gate::denies('permiso_ruta',$ruta))
		{
			Session::flash('error', 'No tiene permiso para acceder.');
			return Redirect::back();
		}
        return $next($request);
    }
}
