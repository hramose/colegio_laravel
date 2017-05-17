<?php

namespace App\App\Repositories;

use App\App\Entities\Ciclo;

class CicloRepo extends BaseRepo{

	public function getModel()
	{
		return new Ciclo;
	}

	public function getActual()
	{
		return Ciclo::where('actual',1)->first();
	}

}