<?php

namespace App\App\Repositories;

use App\App\Entities\Materia;
use App\App\Entities\Curso;

class MateriaRepo extends BaseRepo{

	public function getModel()
	{
		return new Materia;
	}

	public function getNotInSeccionByEstado($seccionId,$estados)
	{
		$materiasIds = Curso::where('seccion_id',$seccionId)
							->pluck('materia_id')->toArray();
		return Materia::whereNotIn('id',$materiasIds)
						->whereIn('estado',$estados)
						->orderBy('descripcion')
						->get();
	}

}