<?php

namespace App\App\Managers;

class PlantillaUnidadManager extends BaseManager
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
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	public function save()
	{
		$this->isValid();
		try{			
			$this->entity->fill($this->prepareData($this->data));		
			$this->entity->save();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error", $ex);
		}
	}

}