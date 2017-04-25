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

	/* Maestros */

	function getRulesMaestros()
	{
		$rules = [
			'primer_nombre'  => 'required',
			'primer_apellido'  => 'required',
			'fecha_nacimiento' => 'required|date',
			'cui' => 'required',
			'direccion' => 'required',
			'estado' => 'required'
		];
		return $rules;
	}

	function prepareDataMaestros($data)
	{
		$data['rol'] = 'M';
		return $data;
	}

	function saveMaestro()
	{
		$rules = $this->getRulesMaestros();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{			
			$this->entity->fill($this->prepareDataMaestros($this->data));		
			$this->entity->save();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}