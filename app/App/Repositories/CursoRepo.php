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
					->orderBy('orden')
					->get();
	}

	public function getBySeccionByMateriasNotInSeccion($seccionId, $seccion2Id)
	{
		$materiasIds = \DB::table('curso')->where('seccion_id',$seccionId)
							->pluck('materia_id')->toArray();
		return Curso::where('seccion_id',$seccion2Id)
					->whereNotIn('materia_id',$materiasIds)
					->orderBy('orden')
					->get();
	}

	public function getByCicloByMaestro($cicloId, $maestroId)
	{
		return Curso::where('maestro_id',$maestroId)
						->whereHas('seccion', function($q) use ($cicloId){
							$q->where('ciclo_id',$cicloId);
						})
						->with('seccion')
						->with('seccion.grado')
						->with('materia')
						->orderBy('seccion_id')
						->orderBy('orden')
						->get();
	}

	public function getByCicloByEstudiante($cicloId, $estudianteId)
	{
		return Curso::whereHas('seccion',function($q) use ($estudianteId)
						{
							$q->whereHas('estudiantes', function($w) use ($estudianteId){
								$w->where('estudiante_id',$estudianteId);
							});
						})
						->with('seccion')
						->with('seccion.grado')
						->with('materia')
						->orderBy('seccion_id')
						->orderBy('orden')
						->get();
	}

}