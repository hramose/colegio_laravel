<?php

namespace App\App\Managers;

class MensajeForoManager extends BaseManager
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
            'foro_id'  => 'required',
			'mensaje'  => 'required',
            'autor_id' => 'required',
			'estado'   => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}