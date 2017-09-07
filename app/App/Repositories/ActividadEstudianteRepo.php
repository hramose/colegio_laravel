<?php

namespace App\App\Repositories;

use App\App\Entities\ActividadEstudiante;


class ActividadEstudianteRepo extends BaseRepo{

	public function getModel()
	{
		return new ActividadEstudiante;
	}

	public function getByEstudianteByUnidad($estudianteId, $unidadCursoId)
	{
		return ActividadEstudiante::whereHas('actividad', function($q) use ($unidadCursoId){
									$q->where('unidad_curso_id',$unidadCursoId);
								})
								->where('estudiante_id',$estudianteId)
								->with('actividad')
								->with('actividad.tipo')
								->get();
	}

	public function getByUnidad($unidadCursoId)
	{
		return ActividadEstudiante::whereHas('actividad', function($q) use ($unidadCursoId){
									$q->where('unidad_curso_id',$unidadCursoId);
								})
								->with('estudiante')
								->with('actividad')
								->get();
	}

	public function getByActividad($actividadId)
	{
		$actividadesDB = ActividadEstudiante::where('actividad_id',$actividadId)
									->with('estudiante')
									->get();
		return $actividadesDB->sort(function ($a, $b){
  			return strcasecmp($a->estudiante->nombre_completo_apellidos, $b->estudiante->nombre_completo_apellidos);
		});
	}

	public function getBySeccion($unidadSeccionId)
	{
		return ActividadEstudiante::whereHas('actividad', function($q) use ($unidadSeccionId){
									$q->whereHas('unidad_curso',function($w) use ($unidadSeccionId){
										$w->where('unidad_seccion_id',$unidadSeccionId);
									});
								})

								->with('estudiante')
								->with('actividad')
								->with('actividad.unidad_curso')
								->get();
	}

	public function getBySeccionByCursoByEstudiante($unidadSeccionId, $cursoId, $estudianteId)
	{
		return ActividadEstudiante::whereHas('actividad', function($q) use ($unidadSeccionId, $cursoId){
									$q->whereHas('unidad_curso',function($w) use ($unidadSeccionId, $cursoId){
										$w->where('unidad_seccion_id',$unidadSeccionId)
											->where('curso_id',$cursoId);
									});
								})
								->where('estudiante_id',$estudianteId)
								->with('estudiante')
								->with('actividad')
								->with('actividad.unidad_curso')
								->get();
	}

}