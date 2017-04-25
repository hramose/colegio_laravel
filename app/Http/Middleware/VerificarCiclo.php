<?php

namespace App\Http\Middleware;

use Closure, Redirect, Session;

class VerificarCiclo
{

    public function handle($request, Closure $next)
    {
    	$cicloId = session('ciclo_id');
        if (is_null($cicloId)) {
        	Session::flash('error','Elija un ciclo para continuar.');
            return Redirect::route('elegir_ciclo');
        }

        return $next($request);
    }
}
