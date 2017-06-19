<?php

namespace App\App\Repositories;

use App\App\Entities\Foro;


class ForoRepo extends BaseRepo{

	public function getModel()
	{
		return new Foro;
	}

	public function getByCurso($cursoId)
	{
		return Foro::where('curso_id',$cursoId)->with('autor')->with('mensajes')->get();
	}

}