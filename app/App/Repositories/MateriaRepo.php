<?php

namespace App\App\Repositories;

use App\App\Entities\Materia;

class MateriaRepo extends BaseRepo{

	public function getModel()
	{
		return new Materia;
	}

}