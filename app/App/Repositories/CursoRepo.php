<?php

namespace App\App\Repositories;

use App\App\Entities\Curso;

class CursoRepo extends BaseRepo{

	public function getModel()
	{
		return new Curso;
	}

	public function getBySeccion($seccionId)
	{
		return Curso::where('seccion_id',$seccionId)
					->with('seccion')->with('maestro')->with('materia')
					->get();
	}

}