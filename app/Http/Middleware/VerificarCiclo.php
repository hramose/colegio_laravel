<?php

namespace App\Http\Middleware;

use Closure, Redirect, Session, Variable;

class VerificarCiclo
{

    public function handle($request, Closure $next)
    {
    	$ciclo = Variable::getCiclo();
        if (is_null($ciclo)) {
        	Session::flash('error','Elija un ciclo para continuar.');
            return Redirect::route('elegir_ciclo');
        }

        return $next($request);
    }
}
