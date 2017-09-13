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
			'genero' => 'required',
			'estado' => 'required'
		];
		return $rules;
	}

	/* Estudiantes */

	function getRulesEstudiantes()
	{
		$rules = [
			'primer_nombre'  => 'required',
			'primer_apellido'  => 'required',
			'fecha_nacimiento' => 'required|date',
			'direccion' => 'required',
			'genero' => 'required',
			'estado' => 'required'
		];
		return $rules;
	}

	function prepareDataMaestros($data)
	{
		$data['rol'] = 'M';
		return $data;
	}

	function prepareDataEstudiantes($data)
	{
		$data['rol'] = 'E';
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
			\DB::beginTransaction();

			$this->entity->fill($this->prepareDataMaestros($this->data));
			if(is_null($this->entity->id))
			{
				$this->entity->fotografia = $this->entity->genero=='M'?'personas/male.png':'personas/female.png';
			}
			$this->entity->save();
			if(\Input::hasFile('fotografia'))
			{
				$image = \Input::file('fotografia');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->fotografia = $image->storeAs('personas',$imageName,'public');
			}
			$this->entity->save();

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

	function saveEstudiante()
	{
		$rules = $this->getRulesEstudiantes();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{
			\DB::beginTransaction();

			$this->entity->fill($this->prepareDataEstudiantes($this->data));
			if(is_null($this->entity->id))
			{
				$this->entity->fotografia = $this->entity->genero=='M'?'personas/boy.png':'personas/girl.png';
			}
			$this->entity->save();
			if(\Input::hasFile('fotografia'))
			{
				$image = \Input::file('fotografia');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->fotografia = $image->storeAs('personas',$imageName,'public');
			}
			$this->entity->save();

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}