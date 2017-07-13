<?php

namespace App\App\Managers;

class MateriaManager extends BaseManager
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
			return true;
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			if(str_contains($mensaje, 'numero_UNIQUE')){			

				$error = 'El numero de la materia ya existe. Por favor ingrese otro.';


				throw new SaveDataException("Error", new \Exception($error));
			}
			throw new SaveDataException("Error", $ex);
		}
	}

}