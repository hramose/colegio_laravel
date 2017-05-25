<?php

namespace App\App\Repositories;

use App\App\Entities\Unidad;


class UnidadRepo extends BaseRepo{

	public function getModel()
	{
		return new Unidad;
	}

	public function getByCurso($cursoId)
	{
		return Unidad::where('curso_id',$cursoId)->get();
	}

}