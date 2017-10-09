<?php

namespace App\App\Repositories;

use App\App\Entities\PlantillaUnidad;

class PlantillaUnidadRepo extends BaseRepo{

	public function getModel()
	{
		return new PlantillaUnidad;
	}

}