<?php

namespace App\App\Repositories;

use App\App\Entities\DetallePlantillaUnidad;


class DetallePlantillaUnidadRepo extends BaseRepo{

	public function getModel()
	{
		return new DetallePlantillaUnidad;
	}

	public function getByPlantilla($plantillaId)
	{
		return DetallePlantillaUnidad::where('plantilla_unidad_id',$plantillaId)->get();
	}

}