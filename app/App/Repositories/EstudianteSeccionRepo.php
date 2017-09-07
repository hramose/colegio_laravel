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
		$estudiantes = EstudianteSeccion::where('seccion_id',$seccionId)
									->with('estudiante')
									->get();
		$estudiantes = $estudiantes->sort(function ($a, $b){
  			return strcasecmp($a->estudiante->nombre_completo_apellidos, $b->estudiante->nombre_completo_apellidos);
		});
		return $estudiantes;
	}

	public function getBySeccionByEstado($seccionId, $estados)
	{
		return EstudianteSeccion::where('seccion_id',$seccionId)->whereIn('estado',$estados)->with('estudiante')->get();
	}

	public function getByCicloByEstudiante($cicloId, $estudianteId)
	{
		return EstudianteSeccion::where('estudiante_id',$estudianteId)
								->whereHas('seccion',function($q) use ($cicloId){
									$q->where('ciclo_id',$cicloId);
								})
								->first();
	}

}