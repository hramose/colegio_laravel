<?php

namespace App\App\Managers;

class PersonaManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	function getRules()
	{

		$rules = [
			'primer_nombre'  => 'required',
			'primer_apellido'  => 'required',
			'rol'  => 'required',
			'fecha_nacimiento' => 'required|date'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}