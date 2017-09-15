<?php

namespace App\App\Repositories;

use App\App\Entities\User;

class UsuarioRepo extends BaseRepo{

	public function getModel()
	{
		return new User;
	}

	public function all($orderBy)
	{
		return User::with('perfil')->with('persona')->orderBy($orderBy)->get();
	}

	public function getUsuariosByAnio($anio)
	{
		return User::where('username', 'like', $anio.'%')->get();
	}

}