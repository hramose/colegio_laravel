<?php

namespace App\App\Repositories;

use App\App\Entities\MensajeForo;


class MensajeForoRepo extends BaseRepo{

	public function getModel()
	{
		return new MensajeForo;
	}

	public function getByForo($foroId)
	{
		return MensajeForo::where('foro_id',$foroId)->with('foro')->with('autor')->get();
	}

}