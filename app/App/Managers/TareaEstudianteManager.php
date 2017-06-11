<?php

namespace App\App\Managers;

class TareaEstudianteManager extends BaseManager
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
			'tarea_id'  		=> 'required',
			'estudiante_id'  	=> 'required',
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}