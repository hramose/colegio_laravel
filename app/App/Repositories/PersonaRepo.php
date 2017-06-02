<?php

namespace App\App\Repositories;

use App\App\Entities\Persona;
use App\App\Entities\User;

class PersonaRepo extends BaseRepo{

	public function getModel()
	{
		return new Persona;
	}

	public function getByRol($roles)
	{
		return Persona::whereIn('rol',$roles)
			->orderBy('primer_nombre')
			->orderBy('segundo_nombre')
			->orderBy('primer_apellido')
			->orderBy('segundo_apellido')
			->get();
	}

	public function getByRolByEstado($roles, $estados)
	{
		return Persona::whereIn('rol',$roles)
			->whereIn('estado',$estados)
			->orderBy('primer_nombre')
			->orderBy('segundo_nombre')
			->orderBy('primer_apellido')
			->orderBy('segundo_apellido')
			->get();
	}

	public function getWithNoUser()
	{
		$ids = User::pluck('persona_id');
		return Persona::whereNotIn('id',$ids)->get();
	}



}