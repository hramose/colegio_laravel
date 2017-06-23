<?php

namespace App\App\Repositories;

use App\App\Entities\Actividad;


class ActividadRepo extends BaseRepo{

	public function getModel()
	{
		return new Actividad;
	}

	public function getByUnidad($unidadCursoId)
	{
		return Actividad::where('unidad_curso_id',$unidadCursoId)->with('tipo')->get();
	}

	public function getBySeccion($seccionId)
	{
		return Actividad::whereHas('unidad_curso', function($q) use($seccionId){
							$q->whereHas('unidad_seccion', function($w) use ($seccionId){
								$w->where('seccion_id',$seccionId);
							});							
						})
						->get();
	}

}