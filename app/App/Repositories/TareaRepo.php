<?php

namespace App\App\Repositories;

use App\App\Entities\Tarea;


class TareaRepo extends BaseRepo{

	public function getModel()
	{
		return new Tarea;
	}

	public function getByUnidad($unidadId)
	{
		return Tarea::where('unidad_id',$unidadId)->get();
	}

}