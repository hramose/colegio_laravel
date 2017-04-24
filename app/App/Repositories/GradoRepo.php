<?php

namespace App\App\Repositories;

use App\App\Entities\Grado;

class GradoRepo extends BaseRepo{

	public function getModel()
	{
		return new Grado;
	}

}