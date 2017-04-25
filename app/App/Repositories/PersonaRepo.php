<?php

namespace App\App\Repositories;

use App\App\Entities\Persona;

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

}