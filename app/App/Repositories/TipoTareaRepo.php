<?php

namespace App\App\Repositories;

use App\App\Entities\TipoTarea;


class TipoTareaRepo extends BaseRepo{

	public function getModel()
	{
		return new TipoTarea;
	}

}