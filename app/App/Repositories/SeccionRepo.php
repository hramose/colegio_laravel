<?php

namespace App\App\Repositories;

use App\App\Entities\Seccion;

class SeccionRepo extends BaseRepo{

	public function getModel()
	{
		return new Seccion;
	}

	public function getByCiclo($cicloId)
	{
		return Seccion::where('ciclo_id',$cicloId)
						->with('grado')
						->with('maestro')
						->get();
	}

	public function getByCicloByEstado($cicloId, $estados)
	{
		return Seccion::where('ciclo_id',$cicloId)
						->whereIn('estado',$estados)
						->with('grado')
						->with('maestro')
						->orderBy('grado_id')
						->orderBy('seccion')
						->get();
	}

	public function getByCicloByMaestro($cicloId, $maestroId)
	{
		return Seccion::where('ciclo_id',$cicloId)
						->where('maestro_id',$maestroId)
						->with('grado')
						->with('maestro')
						->orderBy('grado_id')
						->orderBy('seccion')
						->get();
	}

}