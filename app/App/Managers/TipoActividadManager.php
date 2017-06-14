<?php

namespace App\App\Managers;

class TipoActividadManager extends BaseManager
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
			'estado'  => 'required',
		];
		return $rules;
	}

	function prepareData($data)
	{
		$data['aplica_zona'] = isset($data['aplica_zona']) ? 1 : 0;
		$data['es_examen'] = isset($data['es_examen']) ? 1 : 0;
		return $data;
	}

}