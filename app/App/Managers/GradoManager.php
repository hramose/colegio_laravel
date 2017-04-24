<?php

namespace App\App\Managers;

class GradoManager extends BaseManager
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
			'descripcion'  => 'required',
			'numero'  => 'required',
			'nivel_academico'  => 'required',
			'estado'  => 'required',
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}