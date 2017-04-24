<?php

namespace App\App\Repositories;

use App\App\Entities\Domo;

class DomoRepo extends BaseRepo{

	public function getModel()
	{
		return new Domo;
	}

}