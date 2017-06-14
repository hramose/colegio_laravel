<?php

namespace App\App\Repositories;

use App\App\Entities\TipoActividad;


class TipoActividadRepo extends BaseRepo{

	public function getModel()
	{
		return new TipoActividad;
	}

}