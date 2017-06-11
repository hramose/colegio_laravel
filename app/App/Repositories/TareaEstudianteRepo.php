<?php

namespace App\App\Repositories;

use App\App\Entities\TareaEstudiante;


class TareaEstudianteRepo extends BaseRepo{

	public function getModel()
	{
		return new TareaEstudiante;
	}

	public function getByEstudianteByUnidad($estudianteId, $unidadId)
	{
		return TareaEstudiante::whereHas('tarea', function($q) use ($unidadId){
									$q->where('unidad_id',$unidadId);
								})
								->where('estudiante_id',$estudianteId)
								->with('tarea')
								->with('tarea.tipo')
								->get();
	}

}