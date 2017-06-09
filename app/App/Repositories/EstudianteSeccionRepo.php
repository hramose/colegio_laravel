<?php

namespace App\App\Repositories;

use App\App\Entities\EstudianteSeccion;

class EstudianteSeccionRepo extends BaseRepo{

	public function getModel()
	{
		return new EstudianteSeccion;
	}

	public function getBySeccion($seccionId)
	{
		return EstudianteSeccion::where('seccion_id',$seccionId)->get();
	}

	public function getBySeccionByEstado($seccionId, $estados)
	{
		return EstudianteSeccion::where('seccion_id',$seccionId)->whereIn('estado',$estados)->get();
	}

}