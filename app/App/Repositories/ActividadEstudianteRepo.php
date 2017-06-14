<?php

namespace App\App\Repositories;

use App\App\Entities\ActividadEstudiante;


class ActividadEstudianteRepo extends BaseRepo{

	public function getModel()
	{
		return new ActividadEstudiante;
	}

	public function getByEstudianteByUnidad($estudianteId, $unidadId)
	{
		return ActividadEstudiante::whereHas('actividad', function($q) use ($unidadId){
									$q->where('unidad_id',$unidadId);
								})
								->where('estudiante_id',$estudianteId)
								->with('actividad')
								->with('actividad.tipo')
								->get();
	}

}