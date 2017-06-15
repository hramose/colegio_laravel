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
		return Actividad::where('unidad_curso_id',$unidadCursoId)->get();
	}

}