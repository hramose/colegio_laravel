<?php

namespace App\App\Repositories;

use App\App\Entities\UnidadCurso;


class UnidadCursoRepo extends BaseRepo{

	public function getModel()
	{
		return new UnidadCurso;
	}

	public function getByCurso($cursoId)
	{
		return UnidadCurso::where('curso_id',$cursoId)->with('unidad_seccion')->get();
	}

}