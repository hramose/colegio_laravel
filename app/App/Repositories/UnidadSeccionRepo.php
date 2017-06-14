<?php

namespace App\App\Repositories;

use App\App\Entities\UnidadSeccion;


class UnidadSeccionRepo extends BaseRepo{

	public function getModel()
	{
		return new UnidadSeccion;
	}

	public function getBySeccion($seccionId)
	{
		return UnidadSeccion::where('seccion_id',$seccionId)->get();
	}

}