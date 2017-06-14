<?php

namespace App\App\Managers;

class ActividadEstudianteManager extends BaseManager
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
			'actividad_id'  		=> 'required',
			'estudiante_id'  	=> 'required',
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}